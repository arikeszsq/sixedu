// components/OnlineService/OnlineService.js
const app = getApp();
Component({
    /**
     * 组件的属性列表
     */
    properties: {
        isShow: {
            type: Boolean,
            value: "true"
        }
    },

    /**
     * 组件的初始数据
     */
    /**
     * 组件的初始数据
     */
    data: {
        info: []
    },
    created() {
        console.log(156132)
        this.getkflists()
    },
    /**
     * 组件的方法列表
     */
    methods: {
        closedHanler() {
            this.triggerEvent('closedHanler')

        },
        getkflists() {
            console.log(9999)
            app.apiRequest({
                url: '/basic/kf/' + wx.getStorageSync('activity_id'),
                method: 'get',
                data: {
                },
                success: res => {
                    var that = this;
                    that.setData({
                        info: res.data.response
                    })
                }
            });
        },

        goMap() {
            wx.openLocation({
                latitude: Number(this.info.latitude),
                longitude: Number(this.info.longitude),
                name: this.info.title,
                address: this.info.province_name + this.info.city_name + this.info.area_name + this.info.address,
                scale: 28
            })
        }
    }
})
