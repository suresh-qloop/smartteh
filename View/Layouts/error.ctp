<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title><?= $title_for_layout ?></title>
	<link rel="icon" href="/favicon.gif" />

	<style type="text/css">

	  * {
		  -moz-box-sizing: border-box;
		  box-sizing: border-box
	  }

	  body {
		  background: #F2F2F2;
		  padding-top: 65px;
		  font-family: Arial, Helvetica, sans-serif;
		  color: #262626
	  }

	  .container {
		  border: 1px solid #ddd;
		  padding-bottom: 45px;
		  border-radius: 8px;
		  background: #FFF;
		  width: 580px;
		  margin: 0 auto
	  }

	  a, a:hover {
		  font-weight: bold;
		  color: #185787
	  }

	  h1, h2, h3 {
		  font-weight: normal;
		  font-size: 30px;
		  margin: 0;
		  padding: 35px 40px 15px
	  }

	  h3 {
		  padding-bottom: 10px;
		  font-size: 24px;
		  padding-top: 0
	  }

	  p {
		  font-weight: normal;
		  line-height: 25px;
		  font-size: 16px;
		  color: #3E434A;
		  margin: 0;
		  padding: 0 40px 25px
	  }

	  nav, pre {
		  border-bottom: 1px solid #DAE3EA;
		  border-top: 1px solid #DAE3EA;
		  background: #F1FAFE;
		  text-align: left;
		  font-size: 14px;
		  color: #1F1F1F;
		  margin: 0;
		  padding: 20px 40px
	  }

	  nav::before {
		  vertical-align: middle;
		  display: inline-block;
		  border-radius: 15px;
		  margin-right: 10px;
		  text-align: center;
		  font-weight: bold;
		  line-height: 30px;
		  background: #5C1611;
		  font-size: 20px;
		  content: "!";
		  height: 30px;
		  width: 30px;
		  color: #fff
	  }

	  pre {
		  margin-bottom: 25px
	  }

	  .cake-stack-trace {
		  margin: 0 0 0 70px;
		  padding: 0
	  }

	  .cake-stack-trace li {
		  margin-bottom: 5px
	  }

	  .cake-stack-trace a {
		  font-weight: normal;
		  font-size: 14px
	  }

	</style>
</head>
<body>

<div class="container">
	<?= $this->fetch('content') ?>
</div>

</body>
</html>
