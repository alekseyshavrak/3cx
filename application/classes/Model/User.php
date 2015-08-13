<?php defined('SYSPATH') or die('No direct script access.');

class Model_User extends ORM {


    public function created($data)
    {
        $phone    = Arr::get($data, 'phone');
        $email    = Arr::get($data, 'email');
        $name     = Arr::get($data, 'name');
        $lastname = Arr::get($data, 'surname');

        # получить последний внутренний номер
        $db = DB::select('authid')->from('extension')->order_by('idextension', 'desc')->limit(1)->execute()->as_array();
        $last_number = current($db);
        $last_number = Arr::get($last_number, 'authid');

        if($last_number != null)
        {
            # Внутрениий номер
            $number = $last_number + 1;

            # добавляем данные в таблицу dn
            $data = array('value' => $number, 'fkidtenant'=> 1);
            $db = DB::insert('dn', array_keys($data))->values($data);
            list($id_db, $rows) = $db->execute();

            # добавляем в таблицу dngrp
            $data = array();
            $data[] = array('fkidgrp' => 2, 'fkiddn' => $id_db, 'roletag'=> '<role name="users" />');
            $data[] = array('fkidgrp' => 3, 'fkiddn' => $id_db, 'roletag'=> '<role name="users" />');

            foreach($data as $value)
            {
                DB::insert('dngrp', array_keys($value))->values($value)->execute();
            }


            # добавляем в таблицу dnprop
            $data = array();
            $data[] = array('fkiddn' => $id_db, 'name'=> 'STARTUPSCREEN', 'description' => 'Start up screen', 'value' => '0');
            $data[] = array('fkiddn' => $id_db, 'name'=> 'MOBILENUMBER', 'description' => 'The mobile number specified for extension', 'value' => $phone);
            $data[] = array('fkiddn' => $id_db, 'name'=> 'PHONESYSUSER_ACCESS', 'description' => 'Specifies if the extension has access to the 3CX Phone System', 'value' => '0');
            $data[] = array('fkiddn' => $id_db, 'name'=> 'REPORTER_ACCESS', 'description' => 'Specifies if the extension has access to the 3CX Web Reporter', 'value' => '0');
            $data[] = array('fkiddn' => $id_db, 'name'=> 'REPORTER_ADMIN', 'description' => 'Allow admin operations in Web Reporter', 'value' => '0');
            $data[] = array('fkiddn' => $id_db, 'name'=> 'REPORTER_SEE_RECORDINGS', 'description' => 'Allow to download any recording from web reporter', 'value' => '0');
            $data[] = array('fkiddn' => $id_db, 'name'=> 'WALLBOARD_ACCESS', 'description' => 'Specifies if the extension has access to the 3CX Wallboard', 'value' => '0');
            $data[] = array('fkiddn' => $id_db, 'name'=> 'HOTELMODULE_ACCESS', 'description' => 'Specifies if the extension has access to the 3CX Hotel Module', 'value' => '0');
            $data[] = array('fkiddn' => $id_db, 'name'=> 'SERVICES_ACCESS_PASSWORD', 'description' => 'Password that will be used by this extension to access 3CX Phone System Services', 'value' => uniqid());
            $data[] = array('fkiddn' => $id_db, 'name'=> 'EXT_MC_ACCESS_TYPE', 'description' => '""', 'value' => '0');
            $data[] = array('fkiddn' => $id_db, 'name'=> 'EXT_MC_ACCESS_GATEWAYS', 'description' => '""', 'value' => '0');
            $data[] = array('fkiddn' => $id_db, 'name'=> 'EXT_MC_ACCESS_SYSTEM', 'description' => '""', 'value' => '0');
            $data[] = array('fkiddn' => $id_db, 'name'=> 'TURNOFFMYPHONE', 'description' => 'Specifies that the extension does not have acces to MyPhone', 'value' => '0');
            $data[] = array('fkiddn' => $id_db, 'name'=> 'HIDEFORWARDRULESTAB', 'description' => 'Hide extension forwarding rules tab in 3cx My Phone', 'value' => '0');
            $data[] = array('fkiddn' => $id_db, 'name'=> 'USETUNNEL', 'description' => 'Enables Tunnel Connection', 'value' => '0');
            $data[] = array('fkiddn' => $id_db, 'name'=> 'SEERECORDING', 'description' => "The 'see' recording rights for corresponding extension", 'value' => '0');
            $data[] = array('fkiddn' => $id_db, 'name'=> 'DELETERECORDING', 'description' => "The 'delete' recording rights for corresponding extension", 'value' => '0');
            $data[] = array('fkiddn' => $id_db, 'name'=> 'EMAILMISSEDCALL', 'description' => 'Send email on missed call to this extension', 'value' => '0');
            $data[] = array('fkiddn' => $id_db, 'name'=> 'REBOUNDSCREENING', 'description' => 'Specifies the call screening', 'value' => '0');
            $data[] = array('fkiddn' => $id_db, 'name'=> 'ALLOW_LAN_ONLY', 'description' => 'Blocks an extension from being registered outside the network', 'value' => '1');
            $data[] = array('fkiddn' => $id_db, 'name'=> 'BLOCKREMOTETUNNEL', 'description' => 'Block Remote extensions registering to the 3CX Phone System using tunnel connections', 'value' => '0');
            $data[] = array('fkiddn' => $id_db, 'name'=> 'VOICEMAILPINAUTH', 'description' => 'Specifies that the extension can read voice mail without pin authentication.Set to 0 will access the VM menu directly', 'value' => '1');
            $data[] = array('fkiddn' => $id_db, 'name'=> 'DONT_SHOW_EXT_IN_PHBK', 'description' => 'Specifies that the extension can read voice mail without pin authentication.Set to 0 will access the VM menu directly', 'value' => '0');
            $data[] = array('fkiddn' => $id_db, 'name'=> 'PINPROTECTED', 'description' => '', 'value' => '0');
            $data[] = array('fkiddn' => $id_db, 'name'=> 'OFFICEHOURSPROPERTIES', 'description' => 'Represents the options for office hours on the current extension', 'value' => '1');
            $data[] = array('fkiddn' => $id_db, 'name'=> 'PBXIP', 'description' => 'Pbx ip for 3CX Phone provisioning', 'value' => '192.168.1.4');
            $data[] = array('fkiddn' => $id_db, 'name'=> 'EXTGUID', 'description' => 'Unique identifier for 3CX phone provisioning', 'value' => '8e323f90-98b2-43bf-acd8-b5dafe8736fb');
            $data[] = array('fkiddn' => $id_db, 'name'=> 'PROVPATH', 'description' => '', 'value' => '0');

            foreach($data as $value)
            {
                DB::insert('dnprop', array_keys($value))->values($value)->execute();
            }


            # добавляем данные в таблицу EXTENSION
            $data = array('fkiddn' => $id_db, 'authid'=> $number, 'authpswd' => uniqid(), 'noanswtimeout' => 15);
            $db = DB::insert('extension', array_keys($data))->values($data);
            list($id_extension, $rows) = $db->execute();



            # добавляем данные в таблицу USERS
            $data = array('fkidextension' => $id_extension, 'firstname'=> $name, 'lastname' => $lastname);
            $db = DB::insert('users', array_keys($data))->values($data);
            list($id_user, $rows) = $db->execute();

            # добавляем данные в таблицу VOICEMAIL
            $data = array('fkiduser' => $id_user, 'pinnumber' => '7755', 'enablevm' => TRUE, 'email' => $email);
            DB::insert('voicemail', array_keys($data))->values($data)->execute();


            # добавляем данные в таблицу fwdprofile
            $data = array();
            $data[] = array('profilename' => 'Available', 'fkidextension' => $id_extension, 'noanswtimeout' => '20', 'ringsim' => TRUE);
            $data[] = array('profilename' => 'Away', 'fkidextension' => $id_extension, 'noanswtimeout' => '20');
            $data[] = array('profilename' => 'Out of office', 'fkidextension' => $id_extension, 'noanswtimeout' => '20');
            $data[] = array('profilename' => 'Custom 1', 'fkidextension' => $id_extension, 'noanswtimeout' => '20', 'ringsim' => FALSE);
            $data[] = array('profilename' => 'Custom 2', 'fkidextension' => $id_extension, 'noanswtimeout' => '20');
            $data[] = array('profilename' => 'Exceptions', 'fkidextension' => $id_extension);

            $fwdprofiles_id = array();
            foreach($data as $key => $value)
            {
                $db = DB::insert('fwdprofile', array_keys($value))->values($value);
                list($id, $rows) = $db->execute();

                $fwdprofiles_id[$key + 1] = $id;
            }



            # добавляем данные в таблицу calendar
            $calendars_id = array();
            for($i = 1; $i<=21; $i++)
            {
                $data = array('dummy' => 0);
                $db = DB::insert('calendar', array_keys($data))->values($data);
                list($id, $rows) = $db->execute();

                $calendars_id[$i] = $id;
            }

            # добавляем данные в таблицу extensionforward
            $data = array();
            $data[] = array('fkidextension' => $id_extension, 'fkidrulecondition' => 1, 'forwardtypeto' => 1, 'fkforwardtodn' => $id_db, 'fwdtooutsidenumber' => '""', 'fkidrulehours' => 1, 'fkidrulecalltype' => 1, 'conditiondata' => '""', 'fkidcalendar' => Arr::get($calendars_id, 1));
            $data[] = array('fkidextension' => $id_extension, 'fkidrulecondition' => 1, 'forwardtypeto' => 1, 'fkforwardtodn' => $id_db, 'fwdtooutsidenumber' => '""', 'fkidrulehours' => 1, 'fkidrulecalltype' => 2, 'conditiondata' => '""', 'fkidcalendar' => Arr::get($calendars_id, 2));
            $data[] = array('fkidextension' => $id_extension, 'fkidrulecondition' => 3, 'forwardtypeto' => 1, 'fkforwardtodn' => $id_db, 'fwdtooutsidenumber' => '""', 'fkidrulehours' => 1, 'fkidrulecalltype' => 1, 'conditiondata' => '""', 'fkidcalendar' => Arr::get($calendars_id, 3));
            $data[] = array('fkidextension' => $id_extension, 'fkidrulecondition' => 2, 'forwardtypeto' => 1, 'fkforwardtodn' => $id_db, 'fwdtooutsidenumber' => '""', 'fkidrulehours' => 1, 'fkidrulecalltype' => 1, 'conditiondata' => '""', 'fkidcalendar' => Arr::get($calendars_id, 4));
            $data[] = array('fkidextension' => $id_extension, 'fkidrulecondition' => 3, 'forwardtypeto' => 1, 'fkforwardtodn' => $id_db, 'fwdtooutsidenumber' => '""', 'fkidrulehours' => 1, 'fkidrulecalltype' => 2, 'conditiondata' => '""', 'fkidcalendar' => Arr::get($calendars_id, 5));
            $data[] = array('fkidextension' => $id_extension, 'fkidrulecondition' => 2, 'forwardtypeto' => 1, 'fkforwardtodn' => $id_db, 'fwdtooutsidenumber' => '""', 'fkidrulehours' => 1, 'fkidrulecalltype' => 2, 'conditiondata' => '""', 'fkidcalendar' => Arr::get($calendars_id, 6));
            $data[] = array('fkidextension' => $id_extension, 'fkidrulecondition' => 4, 'forwardtypeto' => 1, 'fkforwardtodn' => $id_db, 'fwdtooutsidenumber' => '""', 'fkidrulehours' => 1, 'fkidrulecalltype' => 2, 'conditiondata' => '""', 'fkidcalendar' => Arr::get($calendars_id, 7));
            $data[] = array('fkidextension' => $id_extension, 'fkidrulecondition' => 4, 'forwardtypeto' => 1, 'fkforwardtodn' => $id_db, 'fwdtooutsidenumber' => '""', 'fkidrulehours' => 1, 'fkidrulecalltype' => 3, 'conditiondata' => '""', 'fkidcalendar' => Arr::get($calendars_id, 8));
            $data[] = array('fkidextension' => $id_extension, 'fkidrulecondition' => 4, 'forwardtypeto' => 1, 'fkforwardtodn' => $id_db, 'fwdtooutsidenumber' => '""', 'fkidrulehours' => 1, 'fkidrulecalltype' => 1, 'conditiondata' => '""', 'fkidcalendar' => Arr::get($calendars_id, 9));
            $data[] = array('fkidextension' => $id_extension, 'fkidrulecondition' => 4, 'forwardtypeto' => 1, 'fkforwardtodn' => $id_db, 'fwdtooutsidenumber' => '""', 'fkidrulehours' => 1, 'fkidrulecalltype' => 2, 'conditiondata' => '""', 'fkidcalendar' => Arr::get($calendars_id, 10));
            $data[] = array('fkidextension' => $id_extension, 'fkidrulecondition' => 4, 'forwardtypeto' => 1, 'fkforwardtodn' => $id_db, 'fwdtooutsidenumber' => '""', 'fkidrulehours' => 1, 'fkidrulecalltype' => 3, 'conditiondata' => '""', 'fkidcalendar' => Arr::get($calendars_id, 11));
            $data[] = array('fkidextension' => $id_extension, 'fkidrulecondition' => 4, 'forwardtypeto' => 1, 'fkforwardtodn' => $id_db, 'fwdtooutsidenumber' => '""', 'fkidrulehours' => 1, 'fkidrulecalltype' => 1, 'conditiondata' => '""', 'fkidcalendar' => Arr::get($calendars_id, 12));
            $data[] = array('fkidextension' => $id_extension, 'fkidrulecondition' => 1, 'forwardtypeto' => 1, 'fkforwardtodn' => $id_db, 'fwdtooutsidenumber' => '""', 'fkidrulehours' => 1, 'fkidrulecalltype' => 1, 'conditiondata' => '""', 'fkidcalendar' => Arr::get($calendars_id, 13));
            $data[] = array('fkidextension' => $id_extension, 'fkidrulecondition' => 1, 'forwardtypeto' => 1, 'fkforwardtodn' => $id_db, 'fwdtooutsidenumber' => '""', 'fkidrulehours' => 1, 'fkidrulecalltype' => 2, 'conditiondata' => '""', 'fkidcalendar' => Arr::get($calendars_id, 14));
            $data[] = array('fkidextension' => $id_extension, 'fkidrulecondition' => 3, 'forwardtypeto' => 1, 'fkforwardtodn' => $id_db, 'fwdtooutsidenumber' => '""', 'fkidrulehours' => 1, 'fkidrulecalltype' => 1, 'conditiondata' => '""', 'fkidcalendar' => Arr::get($calendars_id, 15));
            $data[] = array('fkidextension' => $id_extension, 'fkidrulecondition' => 2, 'forwardtypeto' => 1, 'fkforwardtodn' => $id_db, 'fwdtooutsidenumber' => '""', 'fkidrulehours' => 1, 'fkidrulecalltype' => 1, 'conditiondata' => '""', 'fkidcalendar' => Arr::get($calendars_id, 16));
            $data[] = array('fkidextension' => $id_extension, 'fkidrulecondition' => 3, 'forwardtypeto' => 1, 'fkforwardtodn' => $id_db, 'fwdtooutsidenumber' => '""', 'fkidrulehours' => 1, 'fkidrulecalltype' => 2, 'conditiondata' => '""', 'fkidcalendar' => Arr::get($calendars_id, 17));
            $data[] = array('fkidextension' => $id_extension, 'fkidrulecondition' => 2, 'forwardtypeto' => 1, 'fkforwardtodn' => $id_db, 'fwdtooutsidenumber' => '""', 'fkidrulehours' => 1, 'fkidrulecalltype' => 2, 'conditiondata' => '""', 'fkidcalendar' => Arr::get($calendars_id, 18));
            $data[] = array('fkidextension' => $id_extension, 'fkidrulecondition' => 4, 'forwardtypeto' => 1, 'fkforwardtodn' => $id_db, 'fwdtooutsidenumber' => '""', 'fkidrulehours' => 1, 'fkidrulecalltype' => 2, 'conditiondata' => '""', 'fkidcalendar' => Arr::get($calendars_id, 19));
            $data[] = array('fkidextension' => $id_extension, 'fkidrulecondition' => 4, 'forwardtypeto' => 1, 'fkforwardtodn' => $id_db, 'fwdtooutsidenumber' => '""', 'fkidrulehours' => 1, 'fkidrulecalltype' => 3, 'conditiondata' => '""', 'fkidcalendar' => Arr::get($calendars_id, 20));
            $data[] = array('fkidextension' => $id_extension, 'fkidrulecondition' => 4, 'forwardtypeto' => 1, 'fkforwardtodn' => $id_db, 'fwdtooutsidenumber' => '""', 'fkidrulehours' => 1, 'fkidrulecalltype' => 1, 'conditiondata' => '""', 'fkidcalendar' => Arr::get($calendars_id, 21));

            $extensionforward_id = array();
            foreach($data as $key => $value)
            {
                $db = DB::insert('extensionforward', array_keys($value))->values($value);
                list($id, $rows) = $db->execute();

                $extensionforward_id[$key + 1] = $id;
            }


            # добавляем данные в таблицу extensionrule2profile
            $data = array();
            $data[] = array('fkidfwdprofile' => Arr::get($fwdprofiles_id, 1), 'fkidextensionforward' => Arr::get($extensionforward_id, 1), 'priority' => 0);
            $data[] = array('fkidfwdprofile' => Arr::get($fwdprofiles_id, 1), 'fkidextensionforward' => Arr::get($extensionforward_id, 2), 'priority' => 1);
            $data[] = array('fkidfwdprofile' => Arr::get($fwdprofiles_id, 1), 'fkidextensionforward' => Arr::get($extensionforward_id, 3), 'priority' => 2);
            $data[] = array('fkidfwdprofile' => Arr::get($fwdprofiles_id, 1), 'fkidextensionforward' => Arr::get($extensionforward_id, 4), 'priority' => 3);
            $data[] = array('fkidfwdprofile' => Arr::get($fwdprofiles_id, 1), 'fkidextensionforward' => Arr::get($extensionforward_id, 5), 'priority' => 4);
            $data[] = array('fkidfwdprofile' => Arr::get($fwdprofiles_id, 1), 'fkidextensionforward' => Arr::get($extensionforward_id, 6), 'priority' => 5);
            $data[] = array('fkidfwdprofile' => Arr::get($fwdprofiles_id, 2), 'fkidextensionforward' => Arr::get($extensionforward_id, 7), 'priority' => 0);
            $data[] = array('fkidfwdprofile' => Arr::get($fwdprofiles_id, 2), 'fkidextensionforward' => Arr::get($extensionforward_id, 8), 'priority' => 1);
            $data[] = array('fkidfwdprofile' => Arr::get($fwdprofiles_id, 2), 'fkidextensionforward' => Arr::get($extensionforward_id, 9), 'priority' => 2);
            $data[] = array('fkidfwdprofile' => Arr::get($fwdprofiles_id, 3), 'fkidextensionforward' => Arr::get($extensionforward_id, 10), 'priority' => 0);
            $data[] = array('fkidfwdprofile' => Arr::get($fwdprofiles_id, 3), 'fkidextensionforward' => Arr::get($extensionforward_id, 11), 'priority' => 1);
            $data[] = array('fkidfwdprofile' => Arr::get($fwdprofiles_id, 3), 'fkidextensionforward' => Arr::get($extensionforward_id, 12), 'priority' => 2);
            $data[] = array('fkidfwdprofile' => Arr::get($fwdprofiles_id, 4), 'fkidextensionforward' => Arr::get($extensionforward_id, 13), 'priority' => 0);
            $data[] = array('fkidfwdprofile' => Arr::get($fwdprofiles_id, 4), 'fkidextensionforward' => Arr::get($extensionforward_id, 14), 'priority' => 1);
            $data[] = array('fkidfwdprofile' => Arr::get($fwdprofiles_id, 4), 'fkidextensionforward' => Arr::get($extensionforward_id, 15), 'priority' => 2);
            $data[] = array('fkidfwdprofile' => Arr::get($fwdprofiles_id, 4), 'fkidextensionforward' => Arr::get($extensionforward_id, 16), 'priority' => 3);
            $data[] = array('fkidfwdprofile' => Arr::get($fwdprofiles_id, 4), 'fkidextensionforward' => Arr::get($extensionforward_id, 17), 'priority' => 4);
            $data[] = array('fkidfwdprofile' => Arr::get($fwdprofiles_id, 4), 'fkidextensionforward' => Arr::get($extensionforward_id, 18), 'priority' => 5);
            $data[] = array('fkidfwdprofile' => Arr::get($fwdprofiles_id, 5), 'fkidextensionforward' => Arr::get($extensionforward_id, 19), 'priority' => 0);
            $data[] = array('fkidfwdprofile' => Arr::get($fwdprofiles_id, 5), 'fkidextensionforward' => Arr::get($extensionforward_id, 20), 'priority' => 1);
            $data[] = array('fkidfwdprofile' => Arr::get($fwdprofiles_id, 5), 'fkidextensionforward' => Arr::get($extensionforward_id, 21), 'priority' => 2);

            $extensionforward_id = array();
            foreach($data as $key => $value)
            {
                $db = DB::insert('extensionrule2profile', array_keys($value))->values($value);
                list($id, $rows) = $db->execute();

                $extensionforward_id[$key + 1] = $id;
            }


            DB::update('extension')
                ->set(array('currentprofile' => Arr::get($fwdprofiles_id, 1)))
                ->set(array('overrideprofile' => Arr::get($fwdprofiles_id, 6)))
                ->where('idextension', '=', $id_extension)
                ->execute();

            return $number;
        }
    }
} 
