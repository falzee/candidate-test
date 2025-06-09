<div id="buildingPartModal" class="fixed inset-0 bg-black bg-opacity-30 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg w-full max-w-xl p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold" id="modalTitle">Add Building Part</h2>
            <button onclick="closeBuildingPartModal()">X</button>
        </div>

        <form id="buildingPartForm" method="POST" action="{{ route('building-part.store', $project) }}">
            @include('building-part._form', ['project' => $project])
            <div class="mt-4 flex justify-end">
                <button type="button" onclick="closeBuildingPartModal()" class="mr-2 px-4 py-2 bg-gray-200 rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openBuildingPartModal() {
        resetForm();
        document.getElementById('modalTitle').innerText = 'Add Building Part';
        document.getElementById('buildingPartForm').action = '{{ route('building-part.store', $project) }}';
        document.getElementById('buildingPartModal').classList.remove('hidden');
    }

    function closeBuildingPartModal() {
        document.getElementById('buildingPartModal').classList.add('hidden');
    }

    function editBuildingPart(data) {
        openBuildingPartModal();
        document.getElementById('modalTitle').innerText = 'Edit Building Part';
        document.getElementById('buildingPartForm').action = `/building-part/${data.id}`;
        document.getElementById('buildingPartForm').insertAdjacentHTML('beforeend', '@method("PUT")');
        document.getElementById('building_part_id').value = data.id;
        document.getElementById('name').value = data.name;
        document.getElementById('building_part_type').value = data.building_part_type;
        document.getElementById('material_type').value = data.material_type;
        document.getElementById('supplier_id').value = data.supplier_id;
    }

    function resetForm() {
        document.getElementById('buildingPartForm').reset();
        const method = document.querySelector('#buildingPartForm input[name="_method"]');
        if (method) method.remove();
    }
</script>
