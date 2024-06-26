 <!-- Modal Create -->
 <div class="modal fade" id="createForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="createFormLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="createFormLabel">Tambah Kriteria</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <form id="formCreate" action="{{ route('kriteria.store') }}" method="POST">
                 @csrf
                 <div class="modal-body">
                     <div class="mb-3">
                         <label for="code" class="form-label">Kode</label>
                         <input type="text" class="form-control" id="code" name="code" required>
                     </div>
                     <div class="mb-3">
                         <label for="name" class="form-label">Nama Alternatif</label>
                         <input type="text" class="form-control" id="name" name="name" required>
                     </div>
                     <div class="mb-3">
                         <label for="type_of_criteria" class="form-label">Jenis Kriteria</label>
                         <select class="form-select" id="type_of_criteria" name="type_of_criteria" required>
                             <option value="">Pilih..</option>
                             <option value="Benefit">Benefit</option>
                             <option value="Cost">Cost</option>
                         </select>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="submit" class="btn btn-primary">Create</button>
                 </div>
             </form>
         </div>
     </div>
 </div>

 <!-- Modal Edit -->
 <div class="modal fade" id="editForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="editFormLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="editFormLabel">Edit Kriteria</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <form id="updateKriteria" action="{{ route('kriteria.update') }}" method="POST">
                 @csrf
                 <div class="modal-body">
                     <input type="hidden" name="id" id="id">
                     <div class="mb-3">
                         <label for="updateCode" class="form-label">Kode</label>
                         <input type="text" class="form-control" id="updateCode" name="code" required>
                     </div>
                     <div class="mb-3">
                         <label for="updateName" class="form-label">Nama Alternatif</label>
                         <input type="text" class="form-control" id="updateName" name="name" required>
                     </div>
                     <div class="mb-3">
                         <label for="updateType" class="form-label">Jenis Kriteria</label>
                         <select class="form-select" id="updateType" name="type_of_criteria" required>
                             <option value="">Pilih...</option>
                             <option value="Benefit">Benefit</option>
                             <option value="Cost">Cost</option>
                         </select>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="submit" class="btn btn-warning">Update</button>
                 </div>
             </form>
         </div>
     </div>
 </div>
