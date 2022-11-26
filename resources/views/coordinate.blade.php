<iframe id="map" src="/admin/custom/map" width="100%" height="500" style="border:none"></iframe>
<script>
    /**
     * 设置坐标点
     */
    function setCoordinate(value) {
        var $coordinate = $('.field_map_points');
        $coordinate.val(value);
    }

    /**
     * 设置坐标区域
     * @param value
     */
    function setCoordinateArea(value) {
        var $coordinate = $('.field_map_area');
        $coordinate.val(value);
    }

    /**
     * 获取坐标
     */
    function getCoordinate() {
        var $coordinate = $('.field_map_points');
        var value = $coordinate.val();
        if (value == '') {
            var str = '30.263812,120.175223';//杭州
            return str.split(',');
        }
        return value.split(',');
    }
</script>
