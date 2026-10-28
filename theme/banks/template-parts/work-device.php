<?php
/**
 * One project inside a device frame: a laptop or a phone. The screen shows the poster frame (or,
 * until there is one, a drawn stand-in of the site), and work.js / case.js swap in the recording
 * when it is near the viewport. With JavaScript off the poster or the stand-in is what you see.
 *
 * Args: item (from banks_core_work_item()), form ('laptop' or 'phone'), tone (1 to 4), eager (bool).
 * Pass items (a list) instead of item to stack several screens in one frame; the first one shows
 * until JavaScript starts cycling them.
 *
 * @package Banks
 */

$b_items = isset( $args['items'] ) ? array_values( $args['items'] ) : array( $args['item'] );
$b_item  = $b_items[0];
$b_form  = isset( $args['form'] ) && 'phone' === $args['form'] ? 'phone' : 'laptop';
$b_tone  = isset( $args['tone'] ) ? (int) $args['tone'] : 1;
$b_eager = ! empty( $args['eager'] );
$b_sfx   = 'phone' === $b_form ? '_phone' : '';
?>
<div class="wk-device wk-device--<?php echo esc_attr( $b_form ); ?>">
	<div class="wk-device__body">
		<div class="wk-screen" data-screen>
			<?php if ( 'laptop' === $b_form ) : ?>
				<div class="wk-bar" aria-hidden="true"><span></span><span></span><span></span><em><?php echo esc_html( $b_item['domain'] ); ?></em></div>
			<?php else : ?>
				<div class="wk-island" aria-hidden="true"></div>
			<?php endif; ?>
			<?php
			foreach ( $b_items as $b_n => $b_it ) :
				$b_video = $b_it[ 'video' . $b_sfx ];
				$b_shot  = $b_it[ 'poster' . $b_sfx ];
				$b_mark  = mb_substr( $b_it['title'], 0, 1 );
				$b_t     = 1 === count( $b_items ) ? $b_tone : ( $b_tone + $b_n - 1 ) % 4 + 1;
				?>
				<div class="wk-view" data-domain="<?php echo esc_attr( $b_it['domain'] ); ?>">
					<?php if ( $b_shot ) : ?>
						<img class="wk-shot" src="<?php echo esc_url( $b_shot ); ?>" alt="<?php echo esc_attr( 'laptop' === $b_form ? sprintf( 'The %s website', $b_it['title'] ) : '' ); ?>" <?php echo $b_eager && ! $b_n ? 'fetchpriority="high"' : 'loading="lazy"'; ?> decoding="async">
					<?php else : ?>
						<div class="wk-mock" data-tone="<?php echo esc_attr( $b_t ); ?>" aria-hidden="true">
							<div class="wk-mock__nav"><b><?php echo esc_html( $b_mark ); ?></b><i></i><i></i><i></i><span></span></div>
							<div class="wk-mock__hero"><small><?php echo esc_html( $b_it['industry'] ); ?></small><strong><?php echo esc_html( $b_it['title'] ); ?></strong><i></i><i></i><span></span></div>
							<div class="wk-mock__grid"><i></i><i></i><i></i></div>
							<div class="wk-mock__band"><i></i><i></i><i></i></div>
							<div class="wk-mock__grid"><i></i><i></i><i></i></div>
							<div class="wk-mock__foot"><i></i><i></i></div>
						</div>
					<?php endif; ?>
					<?php if ( $b_video ) : ?>
						<video class="wk-vid" muted playsinline loop preload="none" data-src="<?php echo esc_url( $b_video ); ?>"<?php echo $b_shot ? ' poster="' . esc_url( $b_shot ) . '"' : ''; ?> aria-hidden="true"></video>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php if ( 'laptop' === $b_form ) : ?>
		<div class="wk-device__base" aria-hidden="true"></div>
	<?php endif; ?>
</div>
