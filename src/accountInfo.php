<?php
require 'content/header.inc.php';

$result = my_query("SELECT * FROM user WHERE id_user = '" . $_SESSION['username'] . "'")[0];
?>
<div class="w-screen h-full max-h-[90vh] flex flex-col justify-center items-center">
    <div class="card card-side bg-base-100 shadow-xl w-1/2">
        <figure>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-circle">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
            </svg>
        </figure>
        <div class="card-body items-center text-center">
            <h2 class="card-title">Dados do Utilizador</h2>
            <p>Veja aqui os seus dados.</p>
            <input type="text" placeholder="Username" id="username" name="username" value="<?php echo $result['username'] ?>" class="input input-bordered mb-4 w-full max-w-xs" disabled />
            <input type="text" placeholder="Email" id="email" name="email" value="<?php echo $result['email'] ?>" class="input input-bordered mb-4 w-full max-w-xs" disabled />
            <input type="password" placeholder="Password" id="new-password" name="new-password" value="placeholder" class="input input-bordered mb-4 w-full max-w-xs" disabled />
            <div class="form-control w-full max-w-xs">
                <label class="label cursor-pointer">
                    <span class="label-text">Administrador</span> 
                    <input type="radio" id="adminYes" name="permitions" class="radio" value="yes" disabled <?php echo ($result['id_type'] == '1' ? "checked" : ""); ?> />
                </label>
                <label class="label cursor-pointer">
                    <span class="label-text">Utilizador</span> 
                    <input type="radio" id="adminNo" name="permitions" class="radio" value="no" disabled <?php echo ($result['id_type'] == '2' ? "checked" : ""); ?> />
                </label>
            </div>
            <a href="editUser.php?id=<?php echo $_SESSION['username'] ?>" class="btn btn-primary w-full max-w-xs text-base mb-3">Editar Utilizador</a>
        </div>
    </div>
</div>

<?php
require 'content/footer.inc.html';
