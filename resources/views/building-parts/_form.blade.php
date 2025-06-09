@csrf
<input type="hidden" name="building_part_id" id="building_part_id">
<input type="hidden" name="project_id" value="{{ $project->id }}">

<div class="mb-4">
    <label>Name</label>
    <input type="text" name="name" id="name" class="w-full border rounded p-2" required>
</div>

<div class="mb-4">
    <label>Building Part Type</label>
    <select name="building_part_type" id="building_part_type" class="w-full border rounded p-2" required>
        <option value="">Select</option>
        <option value="floor">Floor</option>
        <option value="wall">Wall</option>
        <option value="beam">Beam</option>
        <option value="column">Column</option>
    </select>
</div>

<div class="mb-4">
    <label>Material Type</label>
    <select name="material_type" id="material_type" class="w-full border rounded p-2" required>
        <option value="">Select material</option>
        <option value="CLT">CLT</option>
        <option value="GLT">GLT</option>
    </select>
</div>

<div class="mb-4">
    <label>Supplier</label>
    <select name="supplier_id" id="supplier_id" class="w-full border rounded p-2" required>
        <option value="">Loading suppliers...</option>
    </select>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Load supplier options via AJAX
    fetch('/api/suppliers')
        .then(response => response.json())
        .then(suppliers => {
            const supplierSelect = document.getElementById('supplier_id');
            supplierSelect.innerHTML = '<option value="">Select supplier</option>';
            suppliers.forEach(supplier => {
                const option = document.createElement('option');
                option.value = supplier.id;
                option.textContent = supplier.name;
                supplierSelect.appendChild(option);
            });
        });

    // Material type filtering based on building part type
    document.getElementById('building_part_type').addEventListener('change', function () {
        const material = document.getElementById('material_type');
        const selected = this.value;
        material.innerHTML = '<option value="">Select material</option>';

        if (['floor', 'wall'].includes(selected)) {
            material.innerHTML += '<option value="CLT">CLT</option>';
        } else if (selected === 'beam') {
            material.innerHTML += '<option value="CLT">CLT</option>';
            material.innerHTML += '<option value="GLT">GLT</option>';
        } else if (selected === 'column') {
            material.innerHTML += '<option value="GLT">GLT</option>';
        }
    });
});
</script>
