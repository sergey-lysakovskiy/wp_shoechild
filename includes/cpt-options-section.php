<?php
add_action ('shoestrap_include_files','cpt_options_sections');

function cpt_options_sections() {
    if( !class_exists( 'ShoestrapCptOptionsSections' ) ) {
        /**
        * Build the Admin section, settings etc.
        */

        class ShoestrapCptOptionsSections {
            function __construct() {
                add_filter( 'redux/options/' . SHOESTRAP_OPT_NAME . '/sections', array( $this, 'options' ), 85 ); 
            }

            /*
             * The options
             */
            function options( $sections ) {
                $post_types = get_post_types(array(),'objects');
                $i = 7;
                
                foreach ( $post_types as $key => $post_type ):
                    if($post_type->has_archive):
                        // Add a new section to redux
                        $section = array(
                            'title' => __( $post_type->labels->name, 'shoestrap' ),
                            'icon' => 'el-icon-caret-down icon-large'
                        );
                        
                        $fields[] = array( 
                            'title'       => __( 'Number of entries per page', 'shoestrap' ),
                            'desc'        => __( 'Choose how many entries should be displayed at page archive.', 'shoestrap' ),
                            'id'          => $key . '_posts_per_page', // Must be unique
                            'default'     => get_option('posts_per_page'),
                            'min'       => 1,
                            'step'      => 1,
                            'max'       => 100,
                            'edit'      => 1,
                            'type'      => 'slider',
                        );
                        $fields[] = array(
                                'title'     => __( 'Infinite scroll', 'shoestrap' ),
                                'desc'      => __( 'Enable infinite scroll for that post type', 'shoestrap' ),
                                'id'        => $key . '_infinite_scroll',
                                'default'   => 0,
                                'type'      => 'switch'
                        );                       

                        $fields[] = array(
                                'title'     => __( 'Layout type', 'shoestrap' ),
                                'desc'      => __( 'Choose how to display entries on archive page', 'shoestrap' ),
                                'id'        => $key . '_layout_type',
                                'type'      => 'button_set',
                                'options'   => array(
                                        '0' => 'Off',
                                        '1' => 'Masonry',
                                        '2' => 'Fit Rows',
                                ),
                                'default'   => 1,
                        );
                        
                       $fields[] = array(
                                'title'     => __( 'Column type', 'shoestrap' ),
                                'desc'      => __( 'What type of columns should be displayed in masonry: with fixed width or responsive', 'shoestrap' ),
                                'required'  => array( $key . '_layout_type','!=',array('0') ),
                                'off'       => __( 'Fixed Width', 'shoestrap' ),
                                'on'        => __( 'Responsive', 'shoestrap' ),
                                'id'        => $key . '_column_type',
                                'default'   => 0,
                                'type'      => 'switch',
                        );                        
                        
                        $fields[] = array( 
                            'title'       => __( 'Number of columns for Large devices', 'shoestrap' ),
                            'desc'        => __( 'Choose how many columns should be displayed at page archive at Large devices. (Desktops)', 'shoestrap' ),
                            'id'          => $key . '_columns_num_lg', // Must be unique
                            'required'  => array( $key . '_column_type','=',array('1') ),
                            'default'     => 2,
                            'min'       => 2,
                            'step'      => 1,
                            'max'       => 12,
                            'edit'      => 1,
                            'type'      => 'slider',
                        );                   
                        
                        $fields[] = array( 
                            'title'       => __( 'Number of columns for Medium devices', 'shoestrap' ),
                            'desc'        => __( 'Choose how many columns should be displayed at page archive at Medium devices. (Desktops)', 'shoestrap' ),
                            'id'          => $key . '_columns_num_md', // Must be unique
                            'required'  => array( $key . '_column_type','=',array('1') ),
                            'default'     => 2,
                            'min'       => 1,
                            'step'      => 1,
                            'max'       => 12,
                            'edit'      => 1,
                            'type'      => 'slider',
                        );                          
                        
                        $fields[] = array( 
                            'title'       => __( 'Number of columns for Small devices', 'shoestrap' ),
                            'desc'        => __( 'Choose how many columns should be displayed at page archive at Small devices. (Tablets)', 'shoestrap' ),
                            'id'          => $key . '_columns_num_sm', // Must be unique
                            'required'  => array( $key . '_column_type','=',array('1') ),
                            'default'     => 2,
                            'min'       => 1,
                            'step'      => 1,
                            'max'       => 12,
                            'edit'      => 1,
                            'type'      => 'slider',
                        );                         
                        
                        $fields[] = array( 
                            'title'       => __( 'Number of columns for Extra small devices', 'shoestrap' ),
                            'desc'        => __( 'Choose how many columns should be displayed at page archive at Extra small devices. (Phones)', 'shoestrap' ),
                            'id'          => $key . '_columns_num_xs', // Must be unique
                            'required'  => array( $key . '_column_type','=',array('1') ),
                            'default'     => 2,
                            'min'       => 1,
                            'step'      => 1,
                            'max'       => 12,
                            'edit'      => 1,
                            'type'      => 'slider',
                        );                          
                        
                        $fields[] = array( 
                            'title'       => __( 'Column width', 'shoestrap' ),
                            'desc'        => __( 'Choose width of the column in pixels', 'shoestrap' ),
                            'id'          => $key . '_column_width', // Must be unique
                            'required'  => array( $key . '_column_type','=',array('0') ),
                            'default'     => 300,
                            'min'       => 100,
                            'step'      => 5,
                            'max'       => 1000,
                            'edit'      => 1,
                            'type'      => 'slider',
                        );                           
                        
                        $fields[] = array( 
                            'title'       => __( 'Column padding', 'shoestrap' ),
                            'desc'        => __( 'Choose padding between the columns in pixels', 'shoestrap' ),
                            'id'          => $key . '_column_padding', // Must be unique
                            'required'  => array( $key . '_layout_type','!=',array('0') ),
                            'default'     => 10,
                            'min'       => 0,
                            'step'      => 1,
                            'max'       => 100,
                            'edit'      => 1,
                            'type'      => 'slider',
                        );                         

                        $section['fields'] = $fields;

                        $section = apply_filters( 'shoestrap_module_footer_options_modifier', $section );
                        
                        array_splice($sections, $i, 0, array ( $section ));
                        $i++;
                    endif;
                endforeach;
                
                return $sections;
            }
        }
        
        $cpt_options = new ShoestrapCptOptionsSections();
    }
}