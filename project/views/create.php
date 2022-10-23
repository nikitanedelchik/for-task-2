<?php
function getStatus($statusParam = false): string
{
    $statusAr = [
        'active',
        'inactive'
    ];
    $block = '';
    foreach ($statusAr as $key => $status) {
        if (isset($statusParam) && $statusParam === $status) {
            $block .= '<option value="' . $status . '" selected="selected">' . $status . '</option>';
        } else {
            $block .= '<option value="' . $status . '">' . $status . '</option>';
        }
    }
    return $block;
}

function getGender($genderParam = false): string
	{
		$genderAr = [
			"male",
			"female"
		];
		$block = '';
		foreach ($genderAr as $key => $gender) {
            if (isset($genderParam) && $genderParam === $gender) {
                $block .= '<option value="' . $gender . '" selected="selected">' . $gender . '</option>';
            } else {
                $block .= '<option value="' . $gender . '">' . $gender . '</option>';
            }
		}
		return $block;
	}
?>
<div class="container">
    <?php if ($model->success) : ?>
        <div class="alert alert-success" role="alert">
            <?= $model->successMessage() ?>
        </div>
    <?php endif; ?>
    <form method="post" action="">
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" name="email" placeholder="Enter email" value="<?= $model->email ?>"
                   class="form-control<?= $model->hasError('email') ? ' is-invalid' : '' ?>"
            >
            <div class="invalid-feedback">
                <?= $model->getMessage('email') ?>
            </div>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Your first and last name</label>
            <input type="text" name="name" placeholder="Enter first and last name" value="<?= $model->name ?>"
                   class="form-control<?= $model->hasError('name') ? ' is-invalid' : '' ?>"
            >
            <div class="invalid-feedback">
                <?= $model->getMessage('name') ?>
            </div>
        </div>
        <div class="form-group">
            <label for="exampleSelect1">Gender</label>
            <select class="form-control" id="exampleSelect1" name="gender">
                <?= getGender($model->gender); ?>
            </select>
            <div class="invalid-feedback">
                <?= $model->getMessage('gender') ?>
            </div>
        </div>
        <div class="form-group">
            <label for="exampleSelect2">Status</label>
            <select class="form-control" id="exampleSelect2" name="status">
                <?= getStatus($model->status); ?>
            </select>
            <div class="invalid-feedback">
                <?= $model->getMessage('status') ?>
            </div>
        </div>
        <button type="submit" name="create" value="go" class="btn btn-primary">Create user</button>
    </form>
</div>