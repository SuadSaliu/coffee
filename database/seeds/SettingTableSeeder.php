<?php

use Illuminate\Database\Seeder;
use Config;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->delete();
        DB::table('settings')->insert(
			array(
					array('key' => 'title','label' => 'Site Title','value' => Config::get('constants.name')),
					array('key' => 'phone','label' => 'Phone','value' => Config::get('constants.phone')),
					array('key' => 'email','label' => 'Email','value' => Config::get('constants.mail_email')),
					array('key' => 'address','label' => 'Address','value' => Config::get('constants.address')),
					array('key' => 'country','label' => 'Country','value' => Config::get('constants.state')),
					array('key' => 'timing1','label' => 'Monday To Saturday','value' => Config::get('constants.work_hours')),
					array('key' => 'sunday','label' => 'Sunday','value' => Config::get('constants.weekend_hours')),
					array('key' => 'facebook','label' => 'Facebook','value' => Config::get('constants.fb')),
					array('key' => 'twitter','label' => 'Twitter','value' => Config::get('constants.tw')),
					array('key' => 'vat','label' => 'VAT','value' => Config::get('constants.vat')),
					array('key' => 'delivery_cost','label' => 'Delivery Cost','value' => Config::get('constants.del_cost')),
					array('key' => 'currency','label' => 'Currency','value' => Config::get('constants.sign')),
					array('key' => 'lng','label' => 'Longitude','value' => Config::get('constants.lng')),
					array('key' => 'lat','label' => 'Latitude','value' => Config::get('constants.lat')),
					array('key' => 'stripe','label' => 'Stripe Payment','value' => Config::get('constants.stripe')),
					array('key' => 'frontend','label' => 'Hide Frontend','value' => Config::get('constants.hide_frontend'))
			));
    }
}
