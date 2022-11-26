// 获取应用实例
const app = getApp();

Page({
    data: {
        news: {}
    },
    onLoad(query) {

        // scene 需要使用 decodeURIComponent 才能获取到生成二维码时传入的 scene
        const scene = decodeURIComponent(query.scene)
        if (scene !== 'undefined') {
            console.log(scene);
            var res = scene.split(',');
            var res_length = res.length;
            var activity_id = res[0];

            if (activity_id == 999999) {
                //999999，表示是用来设置老师为A用户的
                app.apiRequest({
                    url: '/user/set-a/' + id,
                    method: 'get',
                    data: {},
                    success: res => {
                        wx.showToast({
                            title: '您已经成为A用户',
                            icon: 'success', //图标，支持"success"、"loading"
                        }),
                            // var type = res.data.response.type;
                            // var id = res.data.response.activity_id;
                            // if (type === 1) {
                            //     wx.redirectTo({
                            //         url: '../activity/one/index?id=' + id
                            //     });
                            // } else {
                            //     wx.redirectTo({
                            //         url: '../activity/many/index?id=' + id
                            //     });
                            // }
                        }
                });
            } else {
                //设置全局异步缓存activity_id
                wx.setStorageSync('activity_id', activity_id);
                if (res_length >= 2) {
                    var share_user_id = res[1];
                    wx.setStorageSync('share_user_id', share_user_id);
                    //用户邀请用户成功
                    app.apiRequest({
                        url: '/activity/invite-user',
                        method: 'post',
                        data: {
                            'activity_id':activity_id,
                            'parent_user_id':share_user_id
                        },
                        success: res => {
                        }
                    });
                }
                this.toActivityDetail(activity_id);
            }
        }
        console.log('no scene');
        this.getList();
    },

    toDetail: function (event) {
        var id = event.currentTarget.dataset.id;
        var one = event.currentTarget.dataset.one;
        //设置全局异步缓存activity_id
        wx.setStorageSync('activity_id', id)
        if (one === 1) {
            wx.redirectTo({
                url: '../activity/one/index?id=' + id
            });
        } else {
            wx.redirectTo({
                url: '../activity/many/index?id=' + id
            });
        }
    },

    toActivityDetail: function (id) {
        app.apiRequest({
            url: '/activity/type/' + id,
            method: 'get',
            data: {},
            success: res => {
                var type = res.data.response;
                if (type === 1) {
                    wx.redirectTo({
                        url: '../activity/one/index?id=' + id
                    });
                } else {
                    wx.redirectTo({
                        url: '../activity/many/index?id=' + id
                    });
                }
            }
        });
    },

    getList: function () {
        app.apiRequest({
            url: '/activity/lists',
            method: 'get',
            data: {},
            success: res => {
                var that = this;
                console.log(res.data);
                that.setData({
                    news: res.data.response
                })
            }
        });
    }

});
