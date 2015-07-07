<?php
/**
 * Created by PhpStorm.
 * User: Oscar
 * Date: 7/7/2015
 * Time: 10:11 PM
 */

namespace System;


class Form {

    protected $action;

    protected $method;

    protected $field;

    protected $type;

    protected $attributes;

    public function text($name,$value = null,array $attributes = null)
    {
        $field = '<input type="text" id="'.$name.'" name="'.$name.'"';
        $field .= !is_null($value)? ' value="'.$value.'" ' : '';
        if (!is_null($attributes))
        {
            foreach ($attributes as $key => $value){
                $field .= ' '.$key.' = "'.$value.'"  ';
            }
        }

        $field .=' >';


        echo $field;
    }

    public function password($name,$value = null,array $attributes = null)
    {
        $field = '<input type="password" id="'.$name.'" name="'.$name.'"';
        $field .= !is_null($value)? ' value="'.$value.'" ' : '';
        if (!is_null($attributes))
        {
            foreach ($attributes as $key => $value){
                $field .= ' '.$key.' = "'.$value.'"  ';
            }
        }

        $field .=' >';


        echo $field;
    }

    public function textarea($name,$value = null,array $attributes = null)
    {
        $field = '<textarea id="'.$name.'" name="'.$name.'"';
        //$field .= !is_null($value)? ' value="'.$value.'" ' : '';
        if (!is_null($attributes))
        {
            foreach ($attributes as $key => $value){
                $field .= ' '.$key.' = "'.$value.'"  ';
            }
        }

        $field .=' >'.!is_null($value)? ' value="'.$value.'" ' : '';
        $field .= '</textarea>';

        echo $field;
    }

    public function select($name,array $options,$selected = null,array $attributes = null)
    {
        $field = '<select id="'.$name.'" name="'.$name.'"';
        //$field .= !is_null($value)? ' value="'.$value.'" ' : '';
        if (!is_null($attributes))
        {
            foreach ($attributes as $key => $value){
                $field .= ' '.$key.' = "'.$value.'"  ';
            }
        }

        $field .=' >';
        foreach ($options as $key => $value){
            $field .= '<option value="'.$key.'">'.$value.'</option>  ';
        }
        $field .= '</select>';

        echo $field;
    }

    public function number($name,$value = null,array $attributes = null)
    {

    }

    public function file($name,$value = null,array $attributes = null)
    {
        $field = '<input type="file" id="'.$name.'" name="'.$name.'"';
        $field .= !is_null($value)? ' value="'.$value.'" ' : '';
        if (!is_null($attributes))
        {
            foreach ($attributes as $key => $value){
                $field .= ' '.$key.' = "'.$value.'"  ';
            }
        }

        $field .=' >';

        echo $field;
    }

    public function label($field,$text)
    {
        $field = '<label for="'.$field.'">'.$text.'</label>';

        echo $field;
    }

    public function open($method,$action,array $attributes = null,$file = false)
    {
        $field = '<form method="'.$method.'" action="'.url($action,1).'" ';
        if (!is_null($attributes))
        {
            foreach ($attributes as $key => $value){
                $field .= ' '.$key.' = "'.$value.'"  ';
            }
        }

        $field .= !$file? '' : ' enctype = "multipart/form-data"';

        $field .= '>';

        echo $field;

    }

    public function checkbox($name)
    {

    }

    public function close()
    {
        $field = '</form>';

        echo $field;
    }

    public function submit($name= null,$value,array $attributes = null)
    {
        $field = '<input type="submit" id="'.$name.'" name="'.$name.'"';
        $field .= !is_null($value)? ' value="'.$value.'" ' : '';
        if (!is_null($attributes))
        {
            foreach ($attributes as $key => $value){
                $field .= ' '.$key.' = "'.$value.'"  ';
            }
        }

        $field .=' >';


        echo $field;
    }

    public function build(array $form,$method,$action)
    {
        $fm = new Form();
        $fm->open($method,$action);

        foreach ($form as $field=>$type) {
            $field_params = explode('|',$type);
            $field_type = $this->getKey('type',$field_params);
            $attribs = $this->getKey('attributes',$field_params);
            $label = $this->getKey('label',$field_params);
            $value = $this->getKey('value',$field_params);
            $fm->label($field,$label);
            $options = $this->getKey('options',$field_params);
            switch($field_type){
                case 'text':
                    $fm->text($field,$value,$attribs);
                    break;
                case 'password':
                    $fm->password($field,$value,$attribs);
                    break;
                case 'file':
                    $fm->file($field,$value,$attribs);
                    break;
                case 'textarea':
                    $fm->textarea($field,$value,$attribs);
                    break;
                case 'select':
                    $fm->select($field,$options,$value,$attribs);
                    break;
                case 'submit':
                    $fm->submit($field,$value,$attribs);
                    break;
                default:
                    $fm->text($field,$value,$attribs);
                    break;
            }

        }

        $fm->close();

    }

    private function getOptions($string)
    {
        $values= explode(',',$string);

        return ($values);
    }

    protected function getKey($key,array $field_parts)
    {
        foreach ($field_parts as $string){
            $parts = explode(':',$string);

            if ($parts[0] == $key){
                $value = end($parts);
                if ($key == 'options' ){
                    return $this->getOptions($value);
                }
                return $value;
            }


        }

        return null;
    }
}