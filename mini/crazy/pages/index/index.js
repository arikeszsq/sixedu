// 获取应用实例
const app = getApp();

Page({
    data: {
        news: {},
        //banner
        bannerInfo: {
            src: "../../images/activity/delete/banner.png"
        },
        //购买记录
        PurchaseRecordInfo: [
            {
                call: "18115671682",
                avatar: "../../images/activity/delete/avatar.png",
                price: "382.00",
                time: "2022-08-02",
                id: "1"
            },
            {
                call: "18115671682",
                avatar: "../../images/activity/delete/avatar.png",
                price: "382.00",
                time: "2022-08-02",
                id: "2"
            },
            {
                call: "18115671682",
                avatar: "../../images/activity/delete/avatar.png",
                price: "382.00",
                time: "2022-08-02",
                id: "3"
            },
            {
                call: "18115671682",
                avatar: "../../images/activity/delete/avatar.png",
                price: "382.00",
                time: "2022-08-02",
                id: "4"
            },
            {
                call: "18115671682",
                avatar: "../../images/activity/delete/avatar.png",
                price: "382.00",
                time: "2022-08-02",
                id: "5"
            },
        ],
        //活动分类
        ActiveBarList: [{ name: "活动详情", id: "1" }, { name: "机构详情", id: "2" }, { name: "奖励详情", id: "3" }],
        activeIndex: 0,

    },
    onLoad() {
        this.getList();
    },

    toDetail: function (event) {
        var id = event.currentTarget.dataset.id;
        var one = event.currentTarget.dataset.one;
        if (one == 1) {
            wx.navigateTo({
                url: '../activity/one/index?id=' + id
            });
        } else {
            wx.navigateTo({
                url: '../activity/many/index?id=' + id
            });
        }
    },

    getList: function () {
        app.apiRequest({
            url: '/activity/lists',
            method: 'get',
            data: {
            },
            success: res => {
                var that = this;
                console.log(res.data)
                that.setData({
                    news: res.data.response
                })
            }
        });
    },

    bindtapActiveBar(e) {
        this.setData({ activeIndex: e.currentTarget.dataset.index })

    },
    changeCurrent(e) {
        this.setData({ activeIndex: e.detail.current })
    }

})
