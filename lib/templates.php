<?php
class template {
	var $template;
	function template($tf,$t=1) {
		if($t==1){
			$tf='templates/'.$tf.'.html';
			if(file_exists($tf))$this->template=join("", file($tf));else die($tf);
		} elseif($t==2){
			if(lgo($tf)!=NULL)$this->template=lgo($tf);else die($tf);
		} elseif($t==3){
			$this->template=$tf;
		}
	}
	function parse($f) {
		ob_start();
	    include($f);
		$b=ob_get_contents();
		ob_end_clean();
		return $b;
	}
	function replace_tags($ts=array()) {
		if(sizeof($ts) > 0)
			foreach($ts as $t => $d) {
				if(file_exists($d))$d=$this->parse($d);
				$this->template=preg_replace('/{'.$t.'}/i',$d,$this->template);
			}
		else die();
	}
	function ctrlgo() {
		global $_config, $_LG;
		//$data=(file_exists($data)) ? $this->parse($data) : $data;
		$this->template=preg_replace( '!\{_LG_(.*?)\}!e', '\'\'.\$_LG[\'\\1\'].\'\'', $this->template);
		$this->template=preg_replace( '!\{_POST_(.*?)\}!e', '\'\'.htmlspecialchars(stripslashes(\$_POST[\'\\1\'])).\'\'', $this->template);
		$this->replace_tags(array(
		'complete_url' => $_config['complete_url'],
		));
	}
	function template_output() {
	$this->ctrlgo();
	echo $this->template;
	}
	function template_return() {
	return $this->template;
	}
}
?>
