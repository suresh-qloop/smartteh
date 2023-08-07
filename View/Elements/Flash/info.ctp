<?php

$script = 'toastr.info("'.$message.'");';

$this->Html->scriptBlock($script, ['block' => 'script']);
