				</div>

			</div>

			<footer id="footer">
				
				<div class="footer">

					<div class="container box">

						<section id="info" class="row">
							
							<div class="col-md-6"><?php get_sidebar( 'footer-one' ); ?></div>

							<div class="col-md-3"><?php get_sidebar( 'footer-two' ); ?></div>

							<div class="col-md-3"><?php get_sidebar( 'footer-three' ); ?></div>

						</section>

						<span class="back-to-top">
						
							<i class="fa fa-angle-up first-angle"></i>
							<i class="fa fa-angle-up second-angle"></i>

						</span>

					</div>

				</div>

				<div class="socket">

					<div class="container box">

						<div class="copyrights">

                            &copy; EuVou.la Eventos 2018

						</div>

					</div>

				</div>

			</footer>
			
			<div id="skrollr-body"></div>

			<?php
	        	get_template_part( 'partials/part-login-register' );
	    	?>

		</div>

		<?php wp_footer(); ?>

	</body>
	
</html>