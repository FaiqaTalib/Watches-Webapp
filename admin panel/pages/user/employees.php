<?php 
include '../../common/header.php';
include('../../config/conn.php');
?>
<link
  href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Inter:wght@300;400;500;600;700&display=swap"
  rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
  rel="stylesheet" />
<link rel="stylesheet" href="../../assets/css/style.css">
<script src="../../assets/js/script.js"></script>


<?php 
session_start();

if($_SESSION['role']!='admin'){
  header("location: ../../../../e-project/user_panel/pages/login.php");
  exit();
}
?>


<?php
$query = 'SELECT * FROM users';
$res = mysqli_query($conn , $query)





?>







<div class="page-content">
  <div class="page-header">
    <div class="page-title">
      <h2 class="font-serif">Employee Management</h2>
      <p>Manage atelier staff, roles and access levels</p>
    </div>



    
    
  </div>
    <?php 
    
$show_count_query = 'SELECT COUNT(*) AS total FROM users';
$c_res = mysqli_query($conn, $show_count_query);
$s_data = mysqli_fetch_assoc($c_res);
    ?>
  <div class="stat-grid" style="grid-template-columns:repeat(1,1fr);">
    <div class="stat-card">
      <p class="stat-label">Total user</p>
      <h3 class="stat-value"> <?php echo $s_data['total']; ?> </h3>
    </div>
   
  
   
  </div>
 
  <div class="table-card">
    <table>
      <thead>
        <tr>
          <th>User Name</th>
          <th>Phones</th>
          <th>Password</th>
          <!-- <th>Status</th> -->
          <th style="text-align:right;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($res as $data){ ?>
        <tr>
          <td>
            <div style="display:flex;align-items:center;gap:12px;">
              <div class="avatar"><?php echo $data['username'][0] ?></div>
              <div>
                <p style="font-weight:600;"><?php echo $data['username'] ?></p>
                <p style="font-size:0.75rem;color:var(--on-surface-variant);"><?php echo $data['email'] ?></p>
              </div>
            </div>
          </td>
          <td style="font-size:0.8125rem;color:var(--on-surface-variant);"><?php echo $data['phone'] ?></td>
          <td style="font-size:0.8125rem;color:var(--on-surface-variant);"><?php echo $data['password'] ?></td>
          
          
          <td style="text-align:right;">
         
                <a href="delete.php?id=<?php echo $data['id']?>">
                <button class="btn-icon danger" onclick="openDeleteModal()">
                      <span class="material-symbols-outlined">delete</span>
                    </button>
                  </a>
          </td>
        </tr>
        <?php } ?>
       
      </tbody>
    </table>
    <div class="table-pagination">
      <p>Showing <strong>3</strong> of <strong>48</strong> employees</p>
      <div class="pagination-btns"><button class="page-btn active">1</button><button class="page-btn">2</button></div>
    </div>
  </div>
</div>
<div id="add-employee-modal" class="modal-backdrop" onclick="closeModalOnBackdrop(event,'add-employee-modal')">
  <div class="modal-box">
    <div class="modal-header">
      <div>
        <h2>Add Employee</h2>
        <p>New Atelier Staff Member</p>
      </div><button class="close-btn" onclick="closeModal('add-employee-modal')"><span
          class="material-symbols-outlined">close</span></button>
    </div>
    <div class="modal-body">
      <form onsubmit="handleFormSubmit(event,'add-employee-modal','Employee added!')">
        <div style="display:flex;flex-direction:column;gap:20px;">
          <div class="form-group"><label class="form-label">Full Name</label><input type="text" name="name"
              class="form-input" placeholder="e.g. Sofia Ravier" required /></div>
          <div class="form-group"><label class="form-label">Email</label><input type="email" name="email"
              class="form-input" placeholder="sofia@luxrio.com" required /></div>
          <div class="form-group"><label class="form-label">Phone</label><input type="tel" name="phone"
              class="form-input" placeholder="+1 (555) 000-0000" /></div>
          <div class="form-group"><label class="form-label">Role / Title</label><input type="text" name="role"
              class="form-input" placeholder="e.g. Senior Gemologist" required /></div>
          <div class="form-group"><label class="form-label">Department</label><select name="dept" class="form-select">
              <option>Management</option>
              <option>Fine Jewelry</option>
              <option>Timepieces</option>
              <option>Bespoke Atelier</option>
              <option>Client Relations</option>
              <option>Logistics</option>
            </select></div>
          <div class="form-group"><label class="form-label">Access Level</label><select name="access"
              class="form-select">
              <option>Staff</option>
              <option>Manager</option>
              <option>Administrator</option>
            </select></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn-ghost"
            onclick="closeModal('add-employee-modal')">Cancel</button><button type="submit" class="btn-primary">Add
            Employee</button></div>
      </form>
    </div>
  </div>
</div>
<div id="edit-employee-modal" class="modal-backdrop" onclick="closeModalOnBackdrop(event,'edit-employee-modal')">
  <div class="modal-box">
    <div class="modal-header">
      <div>
        <h2>Edit Employee</h2>
        <p>Update Staff Record</p>
      </div><button class="close-btn" onclick="closeModal('edit-employee-modal')"><span
          class="material-symbols-outlined">close</span></button>
    </div>
    <div class="modal-body">
      <form onsubmit="handleFormSubmit(event,'edit-employee-modal','Employee updated!')">
        <input type="hidden" id="eemp-id" />
        <div style="display:flex;flex-direction:column;gap:20px;">
          <div class="form-group"><label class="form-label">Full Name</label><input type="text" id="eemp-name"
              class="form-input" /></div>
          <div class="form-group"><label class="form-label">Email</label><input type="email" id="eemp-email"
              class="form-input" /></div>
          <div class="form-group"><label class="form-label">Phone</label><input type="tel" id="eemp-phone"
              class="form-input" /></div>
          <div class="form-group"><label class="form-label">Role / Title</label><input type="text" id="eemp-role"
              class="form-input" /></div>
          <div class="form-group"><label class="form-label">Department</label><select id="eemp-dept"
              class="form-select">
              <option>Management</option>
              <option>Fine Jewelry</option>
              <option>Timepieces</option>
              <option>Bespoke Atelier</option>
              <option>Client Relations</option>
              <option>Logistics</option>
            </select></div>
          <div class="form-group"><label class="form-label">Status</label><select id="eemp-status" class="form-select">
              <option value="active">Active</option>
              <option value="on_leave">On Leave</option>
              <option value="inactive">Inactive</option>
            </select></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn-ghost"
            onclick="closeModal('edit-employee-modal')">Cancel</button><button type="submit" class="btn-primary">Update
            Employee</button></div>
      </form>
    </div>
  </div>
</div>
<div id="delete-confirm-modal" class="modal-backdrop" onclick="closeModalOnBackdrop(event,'delete-confirm-modal')">
  <div class="modal-box narrow" style="text-align:center;">
    <div class="modal-body" style="display:flex;flex-direction:column;align-items:center;gap:20px;padding:40px 32px;">
      <div
        style="width:64px;height:64px;border-radius:50%;background:rgba(255,180,171,0.1);display:flex;align-items:center;justify-content:center;">
        <span class="material-symbols-outlined" style="color:var(--error);font-size:32px;">delete_forever</span></div>
      <h2 style="font-family:'Noto Serif',serif;font-size:1.25rem;">Confirm Deletion</h2>
      <p style="font-size:0.875rem;color:var(--on-surface-variant);line-height:1.6;">This action is irreversible.</p>
      <input type="hidden" id="del-id" /><input type="hidden" id="del-type" />
      <div style="display:flex;gap:12px;width:100%;"><button onclick="closeModal('delete-confirm-modal')"
          class="btn-secondary" style="flex:1;justify-content:center;">Cancel</button><button
          onclick="closeModal('delete-confirm-modal');showToast('Record deleted.');"
          style="flex:1;padding:12px;background:rgba(147,0,10,0.6);color:var(--error);border:1px solid rgba(255,180,171,0.2);border-radius:8px;cursor:pointer;font-weight:700;font-size:0.875rem;">Delete</button>
      </div>
    </div>
  </div>
</div>
</div>
<?php
include '../../common/FOOTER.php';
?>