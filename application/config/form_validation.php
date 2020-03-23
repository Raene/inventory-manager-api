<?php
$config = array(
        'create_product' => array(
                array(
                        'field' => 'name',
                        'label' => 'Name',
                        'rules' =>  'required'
                ),
                array(
                        'field' => 'price',
                        'label' => 'Price',
                        'rules' => 'required'
                ),
                array(
                        'field' => 'description',
                        'label' => 'Product Description',
                        'rules' => '',
                        'errors' => array(
                                'required' => 'You must provide a %s.',
                        ),
                )
        )
);

