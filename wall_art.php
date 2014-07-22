<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wall_art extends CI_Controller {
   
    public function __construct()
    { 
        parent::__construct();
        $this->load->model('Products');
        $this->load->library('Common');
    }
   
    public function index()
    {
        $data = array();
        $data = $this->Products->get_products(2,1);
        $data['count'] = count($data);
    	$data['products'] = $this->common->_create_product_boxes($data,'wall-art');
    	$data['breadcrumb'] = '';
    	$data['title'] = 'Wall Art - Framed Posters and Signs by Retroville';
        $data['description'] = 'A range of framed replica vintage posters and enamel signs. Based in Caterham, Surrey';
        $data['keywords'] = 'posters, enamel, signs, advertising, shabby, chic, retro, vintage, antique, upcycled, repurposed, furniture, posters, pictures, signs, candles, gifts';
        $data['maincontent'] = $this->load->view('main_wall_art',$data,true);
        $this->common->_build_page($data);
    }

    public function style()
    {
    	$stylesarray = array('1'=>'framed-posters');
    	if($this->uri->segment(2))
    	{
    		if(in_array($this->uri->segment(2),$stylesarray))
    		{
    			if($this->uri->segment(3)) // wall-art/framed-posters/dig-for-victory-posters
    			{
    				$data = array();
    				$productsarray = $this->Products->get_single_product($this->uri->segment(3),2,array_search($this->uri->segment(2),$stylesarray)); // display a single product page
    				if(empty($productsarray))
    				{
    					redirect(base_url().'wall-art/'.$this->uri->segment(2),'location');
    				}
    				$data['title'] = 'Shabby Chic - Vintage - Retro - Antique - Upcycled Furniture by Retroville, Caterham';
        			$data['description'] = 'A range of shabby chic, vintage and retro furniture, posters, signs, gifts more. Based in Caterham, Surrey';
        			$data['keywords'] = 'shabby, chic, retro, vintage, antique, upcycled, repurposed, furniture, posters, pictures, signs, candles, gifts';
    				$data['mainproduct'] = '';
    				$data['otherproducts'] = '';
    				$lastitem = '';
					foreach($productsarray as $k=>$v)
					{
						if($lastitem != $v['id'])
						{
							if($v['slug'] == $this->uri->segment(3))
							{
								$v['height'] = $this->common->_inchtocm($v['height']);
								$v['width'] = $this->common->_inchtocm($v['width']);
								$v['itempindesc'] = $v['itemshortdesc'].' by Retroville';
//								$v['breadcrumb'] = ' &gt; <a href="'.base_url().'wall-art" title="Retroville Wall Art">Wall Art</a>';
								$v['breadcrumb'] = ' &gt; <a href="'.base_url().'wall-art/'.$this->uri->segment(2).'" title="'.ucwords(str_replace('-',' ',$this->uri->segment(2))).'">'.ucwords(str_replace('-',' ',$this->uri->segment(2))).'</a> ';
								$v['breadcrumb'] .= ' &gt; '.ucwords(str_replace('-',' ',$v['itemshortdesc']));
								$data['title'] = $v['itemshortdesc'].' by Retroville';
        						$data['description'] = $v['itemlongdesc'];
        						$data['keywords'] = '';
								$data['mainproduct'] = $this->load->view('item_wall_art',$v,true);
							}
							else // it's one of the other related products 
							{
								$link = '';
								if($v['itemlongdesc'] != '')
								{
									$link = '_link';
									$v['url'] =	'wall-art/'.$this->uri->segment(2).'/'.$v['slug'];
								}
								$data['otherproducts'] .= $this->load->view('item_productbox'.$link,$v,true);
							}
						}
						$lastitem = $v['id'];
					}
        			$data['maincontent'] = $this->load->view('main_productpage',$data,true);
        			$this->common->_build_page($data);
    			}
    			else // wall-art/framed-posters
    			{
    				$data = $this->Products->get_products(2,array_search($this->uri->segment(2),$stylesarray)); // get only framed posters etc
    				$data['count'] = count($data);
    				$data['products'] = $this->common->_create_product_boxes($data,'wall-art');
//    				$data['breadcrumb'] = ' &gt; <a href="'.base_url().'wall-art" title="Retroville Wall Art">Wall Art</a>';
    				$data['breadcrumb'] = ' &gt; <a href="'.base_url().'wall-art/'.$this->uri->segment(2).'" title="'.ucwords(str_replace('-',' ',$this->uri->segment(2))).'">'.ucwords(str_replace('-',' ',$this->uri->segment(2))).'</a> ';
    				$data['productstyle'] = ' '.str_replace('-',' ',$this->uri->segment(2)).' ';
    				$data['title'] = 'Retroville : Shabby Chic - Vintage - Retro - Antique - Upcycled';
      				$data['description'] = 'A range of shabby chic, vintage and retro furniture, posters, signs, gifts more. Based in Caterham, Surrey';
        			$data['keywords'] = 'shabby, chic, retro, vintage, antique, upcycled, repurposed, furniture, posters, pictures, signs, candles, gifts';
        			$data['maincontent'] = $this->load->view('main_wall_art',$data,true);
        			$this->common->_build_page($data);
    			}
    		}
    		else // segment 3 not valid, so redirect back to furniture
    		{
    			redirect(base_url().'wall-art','location');
    		}
    	}
    	else 
    	{
    		redirect(base_url().'wall-art','location');
    	}
    	
    }
    
    function contract()
    {
    	$data['title'] = 'Retroville : Shabby Chic - Vintage - Retro - Antique - Upcycled';
      	$data['description'] = 'A range of shabby chic, vintage and retro furniture, posters, signs, gifts more. Based in Caterham, Surrey';
        $data['keywords'] = 'shabby, chic, retro, vintage, antique, upcycled, repurposed, furniture, posters, pictures, signs, candles, gifts';
        $data['maincontent'] = $this->load->view('main_furniture_commissions',$data,true);
        $this->common->_build_page($data);
    }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */