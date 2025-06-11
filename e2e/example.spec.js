// @ts-check
import { test, expect } from '@playwright/test';

test('user flow - crud project test:', async ({ page }) => {
  await page.goto('http://127.0.0.1:8000/');

  // start
  await page.getByText('Log in').click();
  
  // auth
  await expect(page.getByText("Email")).toBeVisible();
  await page.locator('input[name="email"]').fill('ranapalsu@mail.com');
  await page.getByRole('textbox', { name: 'Password' }).fill('Ranananana');
  await page.getByRole('button', { name: 'Log in' }).click();

  // dashboard
  await expect(page.getByText("Start making your CLT project here!")).toBeVisible();
  await page.getByRole('link', { name: 'Go to Projects' }).click();
  
  // projects page
  await expect(page.getByText("My Project")).toBeVisible();
  await expect(page.getByText("Showing 1 to 10")).toBeVisible();
  
  //ADD BUTTON
  await page.getByRole('button', { name: '+ Add Project' }).click();

  // create failed
  const requiredInputField = page.getByPlaceholder('Insert project name');
  await expect(requiredInputField).toBeVisible();
  await page.getByRole('button', { name: 'Save' }).click();
  const validationMessage = await requiredInputField.evaluate(input => {
          if (input instanceof HTMLInputElement) {
            return input.validationMessage;
          }
          return null;
    });

    expect(validationMessage).not.toBeNull(); 
    expect(validationMessage).toBe("Please fill out this field.");  
  await page.getByRole('button', { name: 'Cancel' }).click();

  // create project success
  await page.getByRole('button', { name: '+ Add Project' }).click();
  await page.locator('input[name="name"]').fill('PROJECT 1');
  await page.locator('textarea[name="description"]').fill('description 1');
  await page.getByRole('button', { name: 'Save' }).click();
  
  await expect(page.getByText("Project Detail - PROJECT 1")).toBeVisible();
  await expect(page.getByText("description 1")).toBeVisible();
  await expect(page.getByText("No building parts found.")).toBeVisible();
  await page.goBack();
  const firstTable = page.locator('table').first();
  const firstRow = firstTable.locator('tbody tr').first();
  await expect(firstRow.getByText("PROJECT 1")).toBeVisible();
  await expect(firstRow.getByText("description 1")).toBeVisible();
  await expect(firstRow.getByRole('link', { name: 'View / Edit' })).toBeVisible();
  await expect(firstRow.getByRole('button', { name: 'Delete' })).toBeVisible();

  // edit project
  await firstRow.getByRole('link', { name: 'View / Edit' }).click();
  await expect(page.getByText("Project Detail - PROJECT 1")).toBeVisible();
  await expect(page.getByText("description 1")).toBeVisible();
  await page.locator('#name').fill('PROJECT 1 edited');
  await page.locator('#description').fill('description 1 edited');
  await page.getByRole('button', { name: 'Update Project' }).click();
  await expect(page.getByText("Project Detail - PROJECT 1 edited")).toBeVisible();
  await expect(page.getByText("description 1 edited")).toBeVisible();
  await page.goBack();
  await page.reload(); 
  await expect(firstRow.getByText("PROJECT 1 edited")).toBeVisible();
  await expect(firstRow.getByText("description 1 edited")).toBeVisible();
  
  // delete cancel
  const deleteForm = firstRow.locator('form', { has: page.getByRole('button', { name: 'Delete' }) });
  
  // page.on('dialog', async dialog => {
  //   // 3. Do stuff with the dialog here (reject/accept etc.)
  //   console.log(dialog.message());
  //   await dialog.dismiss();
  // });
  // await deleteForm.getByRole('button', { name: 'Delete' }).click();
  // await expect(firstRow.getByText("PROJECT 1 edited")).toBeVisible();
  // await expect(firstRow.getByText("description 1 edited")).toBeVisible();
  
  // delete confirm
  page.on('dialog', async dialog => {
    // 3. Do stuff with the dialog here (reject/accept etc.)
    console.log(dialog.message());
    await dialog.accept();
  });
  await deleteForm.getByRole('button', { name: 'Delete' }).click();
  await expect(firstRow.getByText("PROJECT 1 edited")).not.toBeAttached();
  await expect(firstRow.getByText("description 1 edited")).not.toBeAttached();

  // logout
  await page.getByRole('button', { name: 'Muhammad Naufal Ghozi' }).click();
  await page.getByRole('link', { name: 'Log Out' }).click();
  await expect(page.locator('body')).toContainText('Log in');
});


//TEST 2
test('user flow - nested crud for building part test:', async ({ page }) => {

  await page.goto('http://localhost:8000/');
  await page.getByRole('link', { name: 'Log in' }).click();
  await page.getByRole('textbox', { name: 'Email' }).click();
  await page.getByRole('textbox', { name: 'Email' }).fill('ranapalsu@mail.com');
  await page.getByRole('textbox', { name: 'Password' }).click();
  await page.getByRole('textbox', { name: 'Password' }).fill('Ranananana');

  // auth
  await page.getByRole('button', { name: 'Log in' }).click();
  await expect(page.getByRole('paragraph')).toContainText('Start making your CLT project here!');
  await page.getByRole('link', { name: 'Go to Projects' }).click();

  // choose first project
  await expect(page.locator('tbody')).toContainText('PROJECT 1');
  await expect(page.locator('tbody')).toContainText('description 1');
  await page.getByRole('row', { name: 'PROJECT 1 description 1 View' }).getByRole('link').click();

  // prject details confirm
  await expect(page.getByRole('textbox', { name: 'Project Name Name*' })).toHaveValue('PROJECT 1');
  await expect(page.getByRole('textbox', { name: 'Description' })).toHaveValue('description 1');
  await expect(page.locator('h3')).toContainText('Building Parts');
  await expect(page.locator('tbody')).toContainText('No building parts found.');

  // cancel new building part
  await page.getByRole('button', { name: '+ Add Building Part' }).click();
  await page.getByRole('textbox', { name: 'Part name' }).click();
  await page.getByRole('textbox', { name: 'Part name' }).fill('name');
  await expect(page.getByRole('textbox', { name: 'Part name' })).toHaveValue('name');
  await page.getByRole('button', { name: 'Cancel' }).click();

  // create new building part
  await page.getByRole('button', { name: '+ Add Building Part' }).click();
  await expect(page.getByRole('textbox', { name: 'Part name' })).toBeEmpty();
  await page.getByRole('textbox', { name: 'Part name' }).click();
  await page.getByRole('textbox', { name: 'Part name' }).fill('part 1');
  await page.locator('#partType').selectOption('floor');
  await page.locator('#materialType').selectOption('CLT');
  await page.locator('#supplierSelect').selectOption('KLH');
  await page.getByRole('button', { name: 'Save' }).click();

  // read new building part
    await expect(page.getByRole('cell', { name: 'part 1' }).first()).toBeVisible();
  await expect(page.getByRole('cell', { name: 'Floor' }).first()).toBeVisible();
  await expect(page.getByRole('cell', { name: 'CLT' }).first()).toBeVisible();
  await expect(page.getByRole('cell', { name: 'KLH' }).first()).toBeVisible();

  // await expect(page.locator('tbody')).toContainText('part 1');
  // await expect(page.locator('tbody')).toContainText('Floor');
  // await expect(page.locator('tbody')).toContainText('CLT');
  // await expect(page.locator('tbody')).toContainText('KLH');

  // cancel edit building part and verif value
  await page.getByRole('button', { name: 'Edit' }).click();
  await expect(page.getByRole('textbox', { name: 'Part name' })).toHaveValue('part 1');
  await expect(page.locator('#partType')).toHaveValue('floor');
  await expect(page.locator('#materialType')).toHaveValue('CLT');
  await expect(page.locator('#supplierSelect')).toHaveValue('KLH');
  await page.getByRole('button', { name: 'Cancel' }).click();

  // edit success building part
  await page.getByRole('button', { name: 'Edit' }).click();
  await page.getByRole('textbox', { name: 'Part name' }).click();
  await page.getByRole('textbox', { name: 'Part name' }).fill('part 2');
  await page.locator('#partType').selectOption('beam');
  await page.locator('#materialType').selectOption('GLT');
  await page.locator('#supplierSelect').selectOption('Sodra');
  await page.getByRole('button', { name: 'Save' }).click();
  
  // await expect(page.locator('tbody')).toContainText('part 2');//verif edited

  await expect(page.getByRole('cell', { name: 'part 2' }).first()).toBeVisible();
  await expect(page.getByRole('cell', { name: 'beam' }).first()).toBeVisible();
  await expect(page.getByRole('cell', { name: 'GLT' }).first()).toBeVisible();
  await expect(page.getByRole('cell', { name: 'Sodra' }).first()).toBeVisible();

  // delete building part 
  page.once('dialog', dialog => {
    console.log(`Dialog message: ${dialog.message()}`);
    dialog.accept();
  });
  await page.getByRole('button', { name: 'Delete' }).click();
  await page.goto('http://localhost:8000/project/28'); //reload
  await expect(page.locator('tbody')).toContainText('No building parts found.');//verif delete 
  
  // double verif delete success
  await page.getByRole('link', { name: 'Projects' }).click();
  await page.getByRole('row', { name: 'PROJECT 1 description 1 View' }).getByRole('link').click();
  await page.goto('http://localhost:8000/project/28'); 
  await expect(page.locator('tbody')).toContainText('No building parts found.');

  // logout
  await page.getByRole('button', { name: 'Muhammad Naufal Ghozi' }).click();
  await page.getByRole('link', { name: 'Log Out' }).click();
  await expect(page.locator('body')).toContainText('Log in');

});


