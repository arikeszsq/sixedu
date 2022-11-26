// pages/position/position.js

const app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    address: {}
  },

  //移动选点
  moveToLocation: function () {
    var that = this;
    wx.chooseLocation({
      success: function (res) {
        console.log(res);
        that.setData({
          ['address.latitude']: res.latitude,
          ['address.longitude']: res.longitude,
          ['address.name']: res.name
        });

        var map_points = res.latitude + ',' + res.longitude;
        var name = res.name;

        app.apiRequest({
          url: '/user/update',
          method: 'post',
          data: {
            'map_points': map_points,
            'address': name
          },
          success: res => {
            console.log('更新用户家的位置成功')
          }
        })


        wx.setStorageSync('trueCity', that.data.address)
        //选择地点之后返回到原来页面
        console.log('设置家位置成功')
        wx.navigateBack({
          delta: 1,
        })
      },
      fail: function (err) {

        console.log(err)
        // wx.navigateBack({
        //   delta: 1,
        // })
      }
    });
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    const address = wx.getStorageSync('trueCity');
    this.setData({
      address
    })
    this.moveToLocation();
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {

  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  }
})
