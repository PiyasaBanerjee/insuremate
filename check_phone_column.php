<?php
use Illuminate\Support\Facades\Schema;

if (Schema::hasColumn('users', 'phone')) {
    echo "Phone column EXISTS.\n";
} else {
    echo "Phone column DOES NOT EXIST.\n";
}
