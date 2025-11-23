<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('utilities', function (Blueprint $table) {
            // New features to add
            if (!Schema::hasColumn('utilities', 'smart_home_system')) {
                $table->boolean('smart_home_system')->default(0)->after('floor_heating_system');
            }
            if (!Schema::hasColumn('utilities', 'central_heating_hvac')) {
                $table->boolean('central_heating_hvac')->default(0)->after('smart_home_system');
            }
            if (!Schema::hasColumn('utilities', 'walk_in_closets')) {
                $table->boolean('walk_in_closets')->default(0)->after('central_heating_hvac');
            }
            if (!Schema::hasColumn('utilities', 'en_suite_bathrooms')) {
                $table->boolean('en_suite_bathrooms')->default(0)->after('walk_in_closets');
            }
            if (!Schema::hasColumn('utilities', 'built_in_kitchen_appliances')) {
                $table->boolean('built_in_kitchen_appliances')->default(0)->after('en_suite_bathrooms');
            }
            if (!Schema::hasColumn('utilities', 'laundry_room')) {
                $table->boolean('laundry_room')->default(0)->after('built_in_kitchen_appliances');
            }
            if (!Schema::hasColumn('utilities', 'bbq_area')) {
                $table->boolean('bbq_area')->default(0)->after('laundry_room');
            }
            if (!Schema::hasColumn('utilities', 'gated_community_access')) {
                $table->boolean('gated_community_access')->default(0)->after('bbq_area');
            }
            if (!Schema::hasColumn('utilities', 'guest_house_maids_room')) {
                $table->boolean('guest_house_maids_room')->default(0)->after('gated_community_access');
            }
            if (!Schema::hasColumn('utilities', 'private_pool')) {
                $table->boolean('private_pool')->default(0)->after('guest_house_maids_room');
            }
            if (!Schema::hasColumn('utilities', 'landscaped_garden')) {
                $table->boolean('landscaped_garden')->default(0)->after('private_pool');
            }
            if (!Schema::hasColumn('utilities', 'covered_parking')) {
                $table->boolean('covered_parking')->default(0)->after('landscaped_garden');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('utilities', function (Blueprint $table) {
            $columns = [
                'smart_home_system',
                'central_heating_hvac',
                'walk_in_closets',
                'en_suite_bathrooms',
                'built_in_kitchen_appliances',
                'laundry_room',
                'bbq_area',
                'gated_community_access',
                'guest_house_maids_room',
                'private_pool',
                'landscaped_garden',
                'covered_parking',
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('utilities', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};

