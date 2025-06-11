<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
      Project Detail - {{ $project->name }}
    </h2>
  </x-slot>

  <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    {{-- Project Edit Form --}}
    <form action="{{ route('project.update', $project) }}" method="POST" class="mb-8">
      @csrf
      @method('PUT')

      <div class="space-y-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Project Name</label>
          <input type="text" name="name" id="name" value="{{ old('name', $project->name) }}" required
            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
          @error('name')
            <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
          <textarea name="description" id="description" rows="3"
            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description', $project->description) }}</textarea>
          @error('description')
            <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
          @enderror
        </div>

        <button type="submit"
          class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
          Update Project
        </button>
      </div>
    </form>

    {{-- Building Parts Section --}}
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Building Parts</h3>
        <button id="openAddModalBtn"
          class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
          + Add Building Part
        </button>
      </div>

      {{-- Building Parts Table --}}
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
              <th
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                Name
              </th>
              <th
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                Type
              </th>
              <th
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                Material
              </th>
              <th
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                Supplier
              </th>
              <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @forelse ($buildingParts as $part)
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $part->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ ucfirst($part->building_part_type) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $part->material_type }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $part->supplier }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                  <button
                    data-part="{{ json_encode($part) }}"
                    class="editBtn px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                  >Edit</button>

                  <form method="POST" action="{{ route('building-part.destroy', [$project, $part]) }}" class="inline"
                    onsubmit="return confirm('Delete this building part?');">
                    @csrf
                    @method('DELETE')
                    <button
                      type="submit"
                      class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                    >
                      Delete
                    </button>
                  </form>
                </td>
            </tr>
            @empty
              <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No building parts found.</td>
              </tr>
            @endforelse
            <tr>
                <td colspan="5" class="px-6 py-4">
                    {{ $buildingParts->links() }}
                </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    {{-- Modal for Create/Edit Building Part --}}
    <div id="buildingPartModal" class="fixed inset-0 hidden flex items-center justify-center bg-black bg-opacity-50 z-50">      
      <div class="bg-white dark:bg-gray-900 rounded-lg shadow-xl max-w-lg w-full p-6 relative">
        <button id="closeModalBtn" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
          X
        </button>

        <h2 id="modalTitle" class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Add Building Part</h2>

        <form id="buildingPartForm" method="POST" action="{{ route('building-part.store', $project) }}">
          @csrf
          {{-- Use PUT method dynamically for edit --}}
          <input type="hidden" name="_method" id="formMethod" value="POST" />

          <div class="space-y-4">
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name<span class="text-red-500">*</span></label>
              <input type="text" name="name" id="partName" required placeholder="Part name"
                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
              <p class="text-red-500 text-xs mt-1 hidden" id="error-name"></p>
            </div>

            <div>
              <label for="building_part_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Building Part Type<span class="text-red-500">*</span></label>
              <select name="building_part_type" id="partType" required
                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value=""><span class="text-gray-500">Select type</span></option>
                <option value="floor">Floor</option>
                <option value="wall">Wall</option>
                <option value="beam">Beam</option>
                <option value="column">Column</option>
              </select>
              <p class="text-red-500 text-xs mt-1 hidden" id="error-building_part_type"></p>
            </div>

            <div>
              <label for="material_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Material Type<span class="text-red-500">*</span></label>
              <select name="material_type" id="materialType" required
                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="">Select material</option>
                <option value="CLT">CLT</option>
                <option value="GLT">GLT</option>
              </select>
              <p class="text-red-500 text-xs mt-1 hidden" id="error-material_type"></p>
            </div>

            <div>
              <label for="supplier" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Supplier<span class="text-red-500">*</span></label>
              <select name="supplier" id="supplierSelect" required
                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="">Select supplier</option>
                {{-- options will be loaded dynamically --}}
              </select>
              <p class="text-red-500 text-xs mt-1 hidden" id="error-supplier"></p>
            </div>

            <div class="flex justify-end space-x-2 pt-4">
              <button type="button" id="cancelBtn"
                class="px-4 py-2 bg-gray-300 dark:bg-gray-700 rounded hover:bg-gray-400 dark:hover:bg-gray-600 focus:outline-none">
                Cancel
              </button>
              <button type="submit"
                class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Save
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('buildingPartModal');
    const openAddModalBtn = document.getElementById('openAddModalBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const form = document.getElementById('buildingPartForm');
    const modalTitle = document.getElementById('modalTitle');
    const formMethod = document.getElementById('formMethod');

    const nameInput = document.getElementById('partName');
    const typeSelect = document.getElementById('partType');
    const materialSelect = document.getElementById('materialType');
    const supplierSelect = document.getElementById('supplierSelect');

    // Error display helper
    function clearErrors() {
        ['name', 'building_part_type', 'material_type', 'supplier'].forEach(id => {
            const el = document.getElementById('error-' + id);
            if (el) {
                el.textContent = '';
                el.classList.add('hidden');
            }
        });
    }

    // Load suppliers from API
    async function loadAllSuppliers() {
        const res = await fetch('/api/suppliers');
        return await res.json();
    }

    async function updateMaterialAndSuppliers(selectedPartType, preselectedMaterial = null, preselectedSupplier = null) {
        supplierSelect.innerHTML = '<option value="">Select supplier</option>';
        materialSelect.innerHTML = '<option value="">Select material</option>';

        const allSuppliers = await loadAllSuppliers();

        if (['floor', 'wall'].includes(selectedPartType)) {
            allSuppliers.forEach(s => {
                if (s.material_type === 'clt') {
                    supplierSelect.insertAdjacentHTML('beforeend', `<option value="${s.name}">${s.name} &#40;${s.material_type.toUpperCase()}&#41;</option>`);
                }
            });
            materialSelect.innerHTML += '<option value="CLT">CLT</option>';
        } else if (selectedPartType === 'beam') {
            allSuppliers.forEach(s => {
                supplierSelect.insertAdjacentHTML('beforeend', `<option value="${s.name}">${s.name} &#40;${s.material_type.toUpperCase()}&#41;</option>`);
            });
            materialSelect.innerHTML += '<option value="CLT">CLT</option>';
            materialSelect.innerHTML += '<option value="GLT">GLT</option>';
        } else if (selectedPartType === 'column') {
            allSuppliers.forEach(s => {
                if (s.material_type === 'glt') {
                    supplierSelect.insertAdjacentHTML('beforeend', `<option value="${s.name}">${s.name} &#40;${s.material_type.toUpperCase()}&#41;</option>`);
                }
            });
            materialSelect.innerHTML += '<option value="GLT">GLT</option>';
        }

        // Set pre-selected values if provided
        if (preselectedMaterial) {
            materialSelect.value = preselectedMaterial;
        }
        if (preselectedSupplier) {
            supplierSelect.value = preselectedSupplier;
        }
    }


    // Open Add modal
    openAddModalBtn.addEventListener('click', () => {
        modalTitle.textContent = 'Add Building Part';
        formMethod.value = 'POST';
        form.action = "{{ route('building-part.store', $project) }}";

        clearErrors();
        form.reset();
        modal.classList.remove('hidden');
        // On add, load all suppliers initially, and clear material options
        updateMaterialAndSuppliers(''); // Pass an empty string to clear and reset
    });

    // Open Edit modal
    document.querySelectorAll('.editBtn').forEach(btn => {
        btn.addEventListener('click', async e => { // async
            const part = JSON.parse(btn.getAttribute('data-part'));

            modalTitle.textContent = 'Edit Building Part';
            formMethod.value = 'PUT';
            form.action = `/project/{{ $project->id }}/building-part/${part.id}`;

            clearErrors();

            nameInput.value = part.name;
            typeSelect.value = part.building_part_type;

            modal.classList.remove('hidden');

            await updateMaterialAndSuppliers(part.building_part_type, part.material_type, part.supplier);

            // The values should now be correctly set by the updateMaterialAndSuppliers function
            // after it has populated the options.
        });
    });

    // Event listener for partType change (user interaction)
    typeSelect.addEventListener('change', async function() {
        await updateMaterialAndSuppliers(this.value);
    });


    // Close modal
    [closeModalBtn, cancelBtn].forEach(el => {
        el.addEventListener('click', () => {
            modal.classList.add('hidden');
            clearErrors();
            form.reset();
            supplierSelect.innerHTML = '<option value="">Select supplier</option>';
            materialSelect.innerHTML = '<option value="">Select material</option>';
        });
    });
});

</script>
</x-app-layout>
