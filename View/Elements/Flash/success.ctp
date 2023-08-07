<?php

$script = 'toastr.success("'.$message.'");';

$this->Html->scriptBlock($script, ['block' => 'script']);
