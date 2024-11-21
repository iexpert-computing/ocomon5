<?php session_start();
/*      Copyright 2023 Flávio Ribeiro

        This file is part of OCOMON.

        OCOMON is free software; you can redistribute it and/or modify
        it under the terms of the GNU General Public License as published by
        the Free Software Foundation; either version 3 of the License, or
        (at your option) any later version.
        OCOMON is distributed in the hope that it will be useful,
        but WITHOUT ANY WARRANTY; without even the implied warranty of
        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
        GNU General Public License for more details.

        You should have received a copy of the GNU General Public License
        along with Foobar; if not, write to the Free Software
        Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

if (!isset($_SESSION['s_logado']) || $_SESSION['s_logado'] == 0) {
    $_SESSION['session_expired'] = 1;
    echo "<script>top.window.location = '../../index.php'</script>";
    exit;
}

require_once __DIR__ . "/" . "../../includes/include_basics_only.php";
require_once __DIR__ . "/" . "../../includes/classes/ConnectPDO.php";

use includes\classes\ConnectPDO;

$conn = ConnectPDO::getInstance();

$post = $_POST;

$data = [];


$data['child_id'] = (isset($post['child_id']) ? noHtml($post['child_id']) : "");

if (empty($data['child_id'])) {
    return json_encode([]);
}

$asset_info = getEquipmentInfo($conn, null, null, $data['child_id']);

$model = getAssetsModels($conn, $asset_info['comp_marca']);

$data['asset_type'] = $model['tipo'];
$data['manufacturer'] = $model['fabricante'];
$data['model'] = $model['modelo'];
$data['tag'] = $asset_info['comp_inv'];

echo json_encode($data);