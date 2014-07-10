<?php
/*
	Section: Pin Switch
	Author: Enrique Chavez
	Author URI: http://enriquechavez.co
	Description: The "Pin Switch" section allows you to show small information blocks using elegant "bullet" navigation in an easy way. Full color customization with 7 options to choose from. Every single "Pin" element can be configured.
	Class Name: TmSectionPinSwitch
	Workswith: templates, main, header, morefoot, content
	Cloning: true
	Filter: component
*/
class TmSectionPinSwitch extends PageLinesSection {

	function section_persistent(){
	}

	function section_styles(){
		wp_enqueue_script( 'tabpinnes', $this->base_url . '/tabpinnes.js', array( 'jquery' ), '1.0', true );
	}

    function section_head(){

		$base_active   = ($this->opt('tm_pin_active_base_color')) ? pl_hashify($this->opt('tm_pin_active_base_color')) : '#669eff';
		$base_border   = ($this->opt('tm_pin_active_border_color')) ? pl_hashify($this->opt('tm_pin_active_border_color')) : '#ccdfff';

		$base_normal   = ($this->opt('tm_pin_normal_base_color')) ? pl_hashify($this->opt('tm_pin_normal_base_color')) : '#d5d5d5';
		$normal_border = ($this->opt('tm_pin_normal_border_color')) ? pl_hashify($this->opt('tm_pin_normal_border_color')) : '#f5f5f5';

		$line          = ($this->opt('tm_pin_line_color')) ? pl_hashify($this->opt('tm_pin_line_color')) : '#dadada';
		$title         = ($this->opt('tm_pin_title')) ? pl_hashify($this->opt('tm_pin_title')) : '#4c4c4c';
		$desc          = ($this->opt('tm_pin_desription')) ? pl_hashify($this->opt('tm_pin_desription')) : '#4c4c4c';
    ?>
    <style>
		/* PIN SWITCH */
		<?php echo $this->prefix()?> .title{
			color: <?php echo $title ?>;
		}

		<?php echo $this->prefix()?> .description{
			color: <?php echo $desc ?>;
		}

		<?php echo $this->prefix()?> .tabbed .pines .tab a{
			color: <?php echo $base_normal ?>;
		}

		<?php echo $this->prefix()?> .tabbed .pines .tab.active a,
		<?php echo $this->prefix()?> .tabbed .pines .tab:hover a{
			color: <?php echo $base_active ?>;
		}

		<?php echo $this->prefix()?> .tabbed .pines .tab.active a .pin,
		<?php echo $this->prefix()?> .tabbed .pines .tab:hover a .pin{
			background: <?php echo $base_active; ?>;
			box-shadow: 0 0 0 8px <?php echo $base_border; ?>;
		}

		<?php echo $this->prefix()?> .tabbed .pines .tab a .pin{
			background: <?php echo $base_normal ?>;
			box-shadow: 0 0 0 8px <?php echo $normal_border ?>;
		}

		<?php echo $this->prefix()?> .tabbed .pines .tab a .line:before,
		<?php echo $this->prefix()?> .tabbed .pines .tab a .line:after{
			border-bottom: 1px solid <?php echo $line; ?>;
		}
		/* END PIN SWITCH */

    </style>
	<script>
		jQuery(document).ready(function($) {
			jQuery('<?php echo $this->prefix()?> .tabpinnes').tabpinnes();
		});
	</script>
    <?php
    }

	function section_opts(){
		$options = array();

		$options[] = array(
			'type' => 'multi',
			'key' => 'tm_multi_color',
			'title' => __('Pin Switch Color Configuration', 'voyant'),
			'opts' => array(
				array(
					'key' => 'tm_pin_normal_base_color',
					'type' => 'color',
					'title' => __('Normal State Pin Color', 'voyant'),
					'default' => '#d5d5d5'
				),
				array(
					'key' => 'tm_pin_normal_border_color',
					'type' => 'color',
					'title' => __('Normal State Pin Border Color', 'voyant'),
					'default' => '#f5f5f5'
				),
				array(
					'key' => 'tm_pin_active_base_color',
					'type' => 'color',
					'title' => __('Active State Pin Color', 'voyant'),
					'default' => '#669EFF'
				),
				array(
					'key' => 'tm_pin_active_border_color',
					'type' => 'color',
					'title' => __('Active State Pin Border Color', 'voyant'),
					'default' => '#ccdfff'
				),
				array(
					'key' => 'tm_pin_line_color',
					'type' => 'color',
					'title' => __('Line Color', 'voyant'),
					'default' => '#dadada'
				),
				array(
					'key' => 'tm_pin_title',
					'type' => 'color',
					'title' => __('Title Content Color', 'voyant'),
					'default' => '#4c4c4c'
				),
				array(
					'key' => 'tm_pin_desription',
					'type' => 'color',
					'title' => __('Content Color', 'voyant'),
					'default' => '#4c4c4c'
				)
			)
		);

		$options[] = array(
			'key'		=> 'pin_array',
	    	'type'		=> 'accordion',
			'col'		=> 2,
			'title'		=> __('Pin Switch Setup', 'voyant'),
			'post_type'	=> __('Pin', 'voyant'),
			'opts'	=> array(
				array(
					'key'		=> 'title',
					'label'		=> __( 'Content Title', 'voyant' ),
					'type'		=> 'text'
				),
				array(
					'key'		=> 'text',
					'label'	=> __( 'Content Text', 'voyant' ),
					'type'	=> 'textarea'
				),
				array(
					'key'		=> 'icon_title',
					'label'		=> __( 'Icon Title', 'voyant' ),
					'type'		=> 'text'
				),
				array(
					'key'		=> 'icon',
					'label'		=> __( 'Icon (Icon Mode)', 'voyant' ),
					'type'		=> 'select_icon'
				),
			)
	    );

		return $options;
	}

	function section_template()
	{
		$pin_array = $this->opt('pin_array');
	?>

		<div class="holder tabpinnes">
			<div class="row">
				<div class="span12">
					<div class="info">
						<div class="contents">

							<?php 	if (!is_array($pin_array)){
										$pin_array = array('','','');
									}
									$pinnes = count($pin_array);
									$count = 1;
							?>
							<?php
								foreach ($pin_array as $pin):
									$title = pl_array_get( 'title', $pin, 'Pin '. $count);
									$text  = pl_array_get( 'text', $pin, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id lectus sem. Cras consequat lorem. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id lectus sem. Cras consequat lorem.');
							?>

								<div class="ctab" data-name="ctab<?php echo $count ?>">
									<div class="title" data-sync="pin_array_item<?php echo $count?>_title">
										<?php echo $title ?>
									</div>
									<div class="description" data-sync="pin_array_item<?php echo $count?>_text">
										<?php echo do_shortcode( $text ); ?>
									</div>
								</div>
							<?php $count++; endforeach ?>
						</div>
					</div>
				</div>
			</div> <!-- CONTENTS ROW -->
			<div class="row">
				<div class="span12">
					<div class="tabbed">
						<ul class="pines">
							<?php 	if (!is_array($pin_array)){
										$pin_array = array('','','');
									}
									$count = 1;
							?>

							<?php
								foreach ($pin_array as $pin):
									$icon_title = pl_array_get( 'icon_title', $pin, 'Pin '. $count);
									$icon = pl_array_get( 'icon', $pin );
									if(!$icon || $icon == ''){
										$icons = pl_icon_array();
										$icon = $icons[ array_rand($icons) ];
									}
									$width = ( 100 / $pinnes );
							?>
								<li class="tab <?php echo ($count == 1) ? 'active' : '' ?>" style="width:<?php echo $width ?>%">
								    <a href="#tab1" data-name="tab<?php echo $count ?>">
									    <div class="pin"></div>
									    <div class="line"></div>
									    <div class="icon"><i class="icon icon-2x icon-<?php echo $icon ?>"></i></div>
									    <h4 data-sync="pin_array_item<?php echo $count?>_icon_title"><?php echo $icon_title ?></h4>
								    </a>
								</li>
							<?php $count++; endforeach ?>
						</ul>
					</div>
				</div>
			</div> <!-- ROW PINNES -->
		</div> <!-- HOLDER TABPINNES -->

	<?php
	}

}
