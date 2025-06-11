<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Project') }}
        </h2>
    </x-slot>
    <div class="py-12 bg-gray-900 min-h-screen text-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-end items-center mb-6">
                <!-- <a href="" 
                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded text-white font-semibold shadow"
                   id="openAddModalBtn">
                   + New Project
                </a> -->
                <button id="openAddModalBtn"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    + Add Project
                </button>
            </div>
            

            <div class="overflow-x-auto bg-gray-800 rounded shadow">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-300 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-300 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-center text-sm font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-900 divide-y divide-gray-700">
                        @forelse ($projects as $project)
                            <tr>
                                <td class="px-6 py-4 max-w-xs truncate" style="max-width: 200px;">{{ $project->name }}</td>
                                <td class="px-6 py-4 max-w-xs truncate">
                                    {{ $project->description }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap space-x-2 text-center" style="max-width: 70px;">
                                    <a href="{{ route('project.show', $project) }}" 
                                    class="inline-block px-3 py-1 bg-indigo-600 hover:bg-indigo-700 rounded text-sm font-medium">
                                    View / Edit
                                    </a>
                                        <form action="{{ route('project.destroy', $project) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                                Delete
                                            </button>
                                        </form>            
                                                            
                                    </td>       
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No projects found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $projects->links() }}
            </div>

            
            
        </div>
    </div>
</div>
{{-- Modal for Add project --}}
    <div id="newProjectForm" class="fixed inset-0 hidden flex items-center justify-center bg-black bg-opacity-50 z-50">      <div class="bg-white dark:bg-gray-900 rounded-lg shadow-xl max-w-lg w-full p-6 relative">
        <button id="closeModalBtn" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
          X
        </button>

        <h2 id="modalTitle" class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Add Project</h2>

        <form id="projectForm" method="POST" action="{{ route('project.store') }}">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST" />

            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name<span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="partName" required placeholder="Insert project name"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                    <p class="text-red-500 text-xs mt-1 hidden" id="error-name"></p>
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description &#40;Optional&#41;</label>
                    <textarea name="description" id="partDescription" placeholder="Insert project description"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                    <p class="text-red-500 text-xs mt-1 hidden" id="error-name"></p>
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
</x-app-layout>
<script>
    if (window.performance && window.performance.navigation.type === window.performance.navigation.TYPE_BACK_FORWARD) {
        location.reload();
    }

    document.addEventListener('DOMContentLoaded', () => {
      const modal = document.getElementById('newProjectForm');
      const openAddModalBtn = document.getElementById('openAddModalBtn');
      const closeModalBtn = document.getElementById('closeModalBtn');
      const cancelBtn = document.getElementById('cancelBtn');
      const form = document.getElementById('projectForm');
      const modalTitle = document.getElementById('modalTitle');
      const formMethod = document.getElementById('formMethod');


      function clearErrors() {
        ['name'].forEach(id => {
          const el = document.getElementById('error-' + id);
          if (el) {
            el.textContent = '';
            el.classList.add('hidden');
          }
        });
      }

      openAddModalBtn.addEventListener('click', () => {
        modalTitle.textContent = 'Add Project';
        formMethod.value = 'POST';
        form.action = "{{ route('project.store') }}";

        clearErrors();

        form.reset();
        modal.classList.remove('hidden');
      });

      // Close modal
      [closeModalBtn, cancelBtn].forEach(el => {
        el.addEventListener('click', () => {
          modal.classList.add('hidden');
        });
      });
    });

  </script>
