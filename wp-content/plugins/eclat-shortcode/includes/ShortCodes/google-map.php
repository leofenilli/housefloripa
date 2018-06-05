<?php

// [google_map]
function google_map_shortcode($params = array())
{
	$randomid = rand();
	extract(shortcode_atts(array(
		'lat'  => '51.51526',
        'long' => '-0.13218',
        'height' => '600px',
		'zoom' => '17',
		'get_directions_button' => 'enabled',
		'button_text' => esc_html__('Get Directions', 'eclat-shortcodes'),
		'marker' => '',
		'control_elements' => 'enabled',
		'use_my_style' => 'yes',
		'landscape' => '#e9e9e9',
		'road_highway' => '#ffffff',
		'road_arterial' => '#ffffff',
		'road_local' => '#ffffff',
		'water' => '#f5f5f5',
		'poi' => '#f5f5f5'
	), $params));

    if (is_numeric($marker)) {
        $marker_image = wp_get_attachment_url($marker);
    } else {
        $marker_image = get_template_directory_uri().'/images/marker.png';
    }

	ob_start();
	?>

	<script type="text/javascript">

    function initialize() {
        var styles = {
            'eclat':  [
                {
                    "featureType": "water",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "<?php echo esc_html($water); ?>"
                        },
                        {
                            "lightness": 17
                        }
                    ]
                },
                {
                    "featureType": "landscape",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "<?php echo esc_html($landscape); ?>"
                        },
                        {
                            "lightness": 20
                        }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "color": "<?php echo esc_html($road_highway); ?>"
                        },
                        {
                            "lightness": 17
                        }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "geometry.stroke",
                    "stylers": [
                        {
                            "color": "<?php echo esc_html($road_highway); ?>"
                        },
                        {
                            "lightness": 29
                        },
                        {
                            "weight": 0.2
                        }
                    ]
                },
                {
                    "featureType": "road.arterial",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "<?php echo esc_html($road_arterial); ?>"
                        },
                        {
                            "lightness": 18
                        }
                    ]
                },
                {
                    "featureType": "road.local",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "<?php echo esc_html($road_local); ?>"
                        },
                        {
                            "lightness": 16
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "<?php echo esc_html($poi); ?>"
                        },
                        {
                            "lightness": 21
                        }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#dedede"
                        },
                        {
                            "lightness": 21
                        }
                    ]
                },
                {
                    "elementType": "labels.text.stroke",
                    "stylers": [
                        {
                            "visibility": "on"
                        },
                        {
                            "color": "#ffffff"
                        },
                        {
                            "lightness": 16
                        }
                    ]
                },
                {
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "saturation": 36
                        },
                        {
                            "color": "#333333"
                        },
                        {
                            "lightness": 40
                        }
                    ]
                },
                {
                    "elementType": "labels.icon",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "transit",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#f2f2f2"
                        },
                        {
                            "lightness": 19
                        }
                    ]
                },
                {
                    "featureType": "administrative",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "color": "#fefefe"
                        },
                        {
                            "lightness": 20
                        }
                    ]
                },
                {
                    "featureType": "administrative",
                    "elementType": "geometry.stroke",
                    "stylers": [
                        {
                            "color": "#fefefe"
                        },
                        {
                            "lightness": 17
                        },
                        {
                            "weight": 1.2
                        }
                    ]
                }
            ]};
        var Latlng = new google.maps.LatLng(<?php echo esc_html($lat) ?>, <?php echo esc_html($long) ?>);
        var Options = {
            zoom: <?php echo esc_html($zoom) ?>,
            center: Latlng,
            <?php if( $use_my_style == "yes") { ?>
            mapTypeId: 'eclat',
            <?php } else { ?>
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            <?php } ?>
            draggable: true,
            <?php if ($control_elements == "disabled") : ?>
				zoomControl: false,
				panControl: false,
				mapTypeControl: false,
				scaleControl: false,
				streetViewControl: false,
				overviewMapControl: false,
			<?php endif; ?>
            scrollwheel: false
        };
        var map = new google.maps.Map(document.getElementById("map_<?php echo esc_html($randomid); ?>"), Options);

        <?php if( $use_my_style == "yes") { ?>
        var styledMapType = new google.maps.StyledMapType(styles['eclat'], {name: 'eclat'});
        map.mapTypes.set('eclat', styledMapType);
        <?php } ?>

        var marker = new google.maps.Marker({
            position: Latlng,
            map: map,
            title: "",
            clickable: false,
            icon: '<?php echo $marker_image; ?>'
        });
    }
    
    google.maps.event.addDomListener(window, 'load', initialize);
    google.maps.event.addDomListener(window, 'resize', initialize);
    
    </script>
    
    <div id="map_container">
        <div id="map_<?php echo esc_html($randomid); ?>" style="height:<?php echo esc_html($height) ?>;"></div>
        <?php if ($get_directions_button == "enabled") : ?>
        <div class="map_button_wrapper"><div class="map_button_wrapped"><a href="https://maps.google.com/maps?saddr=&amp;daddr=<?php echo esc_html($lat) ?>,<?php echo esc_html($long) ?>&amp;hl=en" id="map_button" target="_blank"><?php echo esc_html($button_text) ?></a></div></div>
        <?php endif; ?>
    </div>

	<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

add_shortcode("google_map", "google_map_shortcode");