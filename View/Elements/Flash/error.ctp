<?php

$script = 'toastr.error("'.$message.'");';

$this->Html->scriptBlock($script, ['block' => 'script']);
