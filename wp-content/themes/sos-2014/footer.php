<?php $base = get_template_directory_uri()."/images/"; ?>

<div class="clear"></div>
<footer>
	<div id="fc">
		<div id="footer">
			<div id="partners" style="float:left">
				<h5>Partners</h5>
				<table style="border-collapse:collapse; margin:0; padding:0">
					<tr><td id="logos">
						<img src="<?php echo $base; ?>footer/mdhhs.png"><br>
						<img src="<?php echo $base; ?>footer/mi_seal.png"><br>
						<img src="<?php echo $base; ?>footer/wayne_state.png">
					</td><td id="partners">
						<a href="https://www.michigan.gov/mdhhs" target="_blank">
							Michigan Department of Health &amp; Human Services</a>
						<a href="http://www.michigan.gov/substanceabuseepi" target="_blank">
							Alcohol/Substance Abuse Epidemiology Program</a>
						<a href="http://www.michigan.gov/mdch/0,4612,7-132-2941_4871---,00.html" target="_blank">
							Office of Recovery Oriented Systems of Care</a>
						<a href="http://www.michigan.gov/" target="_blank">
							State of Michigan</a>
						<a href="https://socialwork.wayne.edu/" target="_blank">
							Wayne State University, School of Social Work</a>	
					</td></tr>
				</table>
			</div>
			
			<div style="float:right; width:350px;">
				<div id="contact" style="margin-bottom:10px;">
					<h5>Contact</h5>
					<h6>Website Feedback</h6>
						<p>
						info@mi-suddr.com
						</p>
					<h6>Data Questions</h6>
						<p>
						Su Min Oh, Epidemiologist<br>
						(517) 373-4700<br>
						ohs@michigan.gov
						</p>
					<h6>Office of Recovery Oriented Systems of Care</h6>
						<p>
						(517) 373-4700<br>
						mdch-bhdda@michigan.gov
						</p>
				</div>
				<div>
					<h5>Site Map</h5>
					<?php wp_nav_menu( array( "menu" => 'main', 'menu_id'=> "footer_nav", 'container'=> false) ); ?>
				</div>
			</div>	
				
		 	<div id="copyright">
			
	     	</div> 
		</div> <!--end fc-->
	</div> <!--end footer-->
</footer>
</div> <!--end wrapper-->
<?php wp_footer(); ?>
<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-56796966-1', 'auto');
	ga('send', 'pageview');
</script>
</body>
</html>