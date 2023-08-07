<?php

if (Configure::read('debug') || $this->Session->check('Admin') || $this->request->header('dnt')) {
	return;
}

?>

<!-- Google Tag Manager (noscript) -->
<noscript>
	<iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MRH4N37" height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
