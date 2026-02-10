<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * render_template()
 * Render the template
 * @access	public
 * @param	
 * @return	string
 */	
if ( ! function_exists('render_template'))
{
    function render_template($array = array())
    {

    	$CI	= & get_instance();
        $page           	=  $array['page'];
       
		$meta_description	= (array_key_exists('meta_description',$array) && !empty($array['meta_description'])) ?  $array['meta_description'] : $CI->config->item('meta_description'); 
		$meta_keywords		= (array_key_exists('meta_keywords',$array) && !empty($array['meta_keywords'])) ?  $array['meta_keywords'] : $CI->config->item('meta_keywords'); 
        $data				= (array_key_exists('data',$array) && !empty($array['data']))  ? $array['data'] : '';
    	$bread_crumb		= (array_key_exists('bread_crumb',$array) && !empty($array['bread_crumb']))  ? $array['bread_crumb'] : '';
		
		//$CI = & get_instance();
       /* if(array_key_exists('title',$array) && !empty($array['title'])) 
        {
            $title = $array['title'];
        }
        else 
        {
             $title =  "Softloom IT solutions"; 
        }
		*/
		
		$title=( (array_key_exists('title',$array) && !empty($array['title'])) ? ($title = $array['title'].' | Softloom IT solutions') :    ($title =  "Softloom IT solutions" ));
		
         $page           =  $array['page'];
         if(array_key_exists('data',$array) && !empty($array['data'])) 
        {
        	$data        =  $array['data'];
        }else{
         	$data        =  '';	
        }
		
		 $meta_author="Softloom";
        $CI->template->write('title', $title);
        $CI->template->write('bread_crumb', $bread_crumb);
        $CI->template->write('meta_description', $meta_description);
        $CI->template->write('meta_keywords', $meta_keywords);
		  $CI->template->write('meta_author', $meta_author);
		
		$CI->template->write_view('header','layout/admin/header.php');
        $CI->template->write_view('side_bar','layout/admin/side_bar.php');
		$CI->template->write_view('content', $page, $data,TRUE);
		$CI->template->write_view('footer','layout/admin/footer.php');
        $CI->template->render();
    }
    
}



// ------------------------------------------------------------------------
/* End of file template_helper.php */
/* Location: ./application/helpers/template_helper.php */
?>