<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BackupController extends Controller
{
    /**
     * Display Database Backup & System Health Center
     */
    public function index()
    {
        $dbName = config('database.connections.mysql.database');
        
        $tables = DB::select('SHOW TABLES');
        $tableKey = 'Tables_in_' . $dbName;
        $tableList = [];
        $totalRows = 0;

        foreach ($tables as $table) {
            $tableName = $table->$tableKey ?? current((array)$table);
            $count = DB::table($tableName)->count();
            $totalRows += $count;
            $tableList[] = [
                'name' => $tableName,
                'rows' => $count,
            ];
        }

        $systemInfo = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'database' => $dbName,
            'db_connection' => config('database.default'),
            'total_tables' => count($tableList),
            'total_rows' => $totalRows,
            'environment' => config('app.env'),
            'debug_mode' => config('app.debug') ? 'সক্রিয় (Debug ON)' : 'নিরাপদ (Production)',
        ];

        return view('admin.backup.index', compact('systemInfo', 'tableList'));
    }

    /**
     * Generate and download pure SQL Dump of the entire database
     */
    public function download(): StreamedResponse
    {
        $dbName = config('database.connections.mysql.database');
        $filename = 'jamirbaria_backup_' . date('Y-m-d_His') . '.sql';

        $tables = DB::select('SHOW TABLES');
        $tableKey = 'Tables_in_' . $dbName;

        $headers = [
            'Content-Type' => 'application/sql',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($tables, $tableKey, $dbName) {
            $handle = fopen('php://output', 'w');

            fwrite($handle, "-- ============================================================\n");
            fwrite($handle, "-- Jamirbaria Sports Academy Database Backup Dump\n");
            fwrite($handle, "-- Generated on: " . date('Y-m-d H:i:s') . "\n");
            fwrite($handle, "-- Database: {$dbName}\n");
            fwrite($handle, "-- ============================================================\n\n");
            fwrite($handle, "SET FOREIGN_KEY_CHECKS=0;\n");
            fwrite($handle, "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n");
            fwrite($handle, "SET time_zone = \"+00:00\";\n\n");

            foreach ($tables as $t) {
                $tableName = $t->$tableKey ?? current((array)$t);

                fwrite($handle, "-- ------------------------------------------------------------\n");
                fwrite($handle, "-- Table structure for `{$tableName}`\n");
                fwrite($handle, "-- ------------------------------------------------------------\n");
                fwrite($handle, "DROP TABLE IF EXISTS `{$tableName}`;\n");

                $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`");
                if (!empty($createTable)) {
                    $createStatement = $createTable[0]->{'Create Table'} ?? '';
                    fwrite($handle, $createStatement . ";\n\n");
                }

                // Dump Table Data in chunks
                $rows = DB::table($tableName)->get();
                if ($rows->count() > 0) {
                    fwrite($handle, "-- Dumping data for table `{$tableName}`\n");
                    foreach ($rows as $row) {
                        $values = [];
                        foreach ((array)$row as $val) {
                            if (is_null($val)) {
                                $values[] = 'NULL';
                            } elseif (is_numeric($val)) {
                                $values[] = $val;
                            } else {
                                $values[] = "'" . addslashes((string)$val) . "'";
                            }
                        }
                        fwrite($handle, "INSERT INTO `{$tableName}` VALUES (" . implode(', ', $values) . ");\n");
                    }
                    fwrite($handle, "\n");
                }
            }

            fwrite($handle, "SET FOREIGN_KEY_CHECKS=1;\n");
            fwrite($handle, "-- Backup completed successfully.\n");
            fclose($handle);
        }, 200, $headers);
    }
}

