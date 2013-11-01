<!-- 
<form name="ccoptin" action="http://visitor.r20.constantcontact.com/d.jsp" target="_blank" method="post" style="margin-bottom:3;">
	<label for="ea">Join our mailing list</label><br />
	<input type="text" name="ea" value="" placeholder="your email..." >
	<input type="submit" name="go" value="SIGN UP" class="submit" >
	<input type="hidden" name="llr" value="r468w8n6">
	<input type="hidden" name="m" value="1011321010161">
	<input type="hidden" name="p" value="oi">
</form>
 -->
 <?php
 	$footer = get_option('t8_options_two_footer');
 	$list = $footer['t8_mailing_list'];
 	echo stripslashes(apply_filters('the_content', $list));
 ?>