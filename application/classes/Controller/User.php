<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User extends Controller {

    public function action_create()
    {
        if ($this->request->method() == Request::POST)
        {
            # Get data
            $data = Arr::extract($_POST, array('name', 'surname', 'email', 'phone'));


            # Create new user
            $number = ORM::factory('User')->created($data);

            $this->request->body(json_encode(array(
                'number' => $number
            )));
        }
    }
}
