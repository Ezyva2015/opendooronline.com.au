<?php

/**
 * @author Saurabh Gupta <mail@thesaurabhgupta.in>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPLv2
 * @version 1.0
 * 
 */

class BP_group_extra_field{

    
    // wrapper function if Buddypress is activate
    
    function __construct() {
        
        
        add_filter( 'groups_custom_group_fields_editable', array($this,'group_fields_html'));
        add_action( 'groups_group_details_edited', array($this,'group_fields_save') );
        add_action( 'groups_created_group',  array($this,'group_fields_save') );
    
    }
    
    
    function group_custom_field($meta_key='') {
        
        return groups_get_groupmeta( bp_get_group_id(), $meta_key) ;
    }
    
    function group_fields_html() {
 
?>
        <label for="completionpermonth">Module Completion Per month</label>
        <input id="completionpermonth" type="text" name="completionpermonth" value="<?php echo $this->group_custom_field('completionpermonth'); ?>" />
        <br>
<?php
    }
   
    
    function group_fields_save( $group_id ) {
        
        $plain_fields = array(
            'completionpermonth'
            );
        foreach( $plain_fields as $field ) {
            $key = $field;
            if ( isset( $_POST[$key] ) ) {
                $value = $_POST[$key];
                groups_update_groupmeta( $group_id, $field, $value );
            }
        }
    }
    
}

new BP_group_extra_field();
