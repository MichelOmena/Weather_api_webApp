<div class ="card my-2 p-3">
    <div>
        <?= $weather_info['info'] ?>
    </div>

    <div class="d-flex align-items-cneter">
        <!-- icon -->
         <div class="me-5">
            <img src="<?php $weather_info['condition_icon'] ?>" class="img-fluid d-block">
         </div>
    </div>
</div>