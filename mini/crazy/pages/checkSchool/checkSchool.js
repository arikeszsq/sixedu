// pages/checkSchool/checkSchool.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    adressObj: {
      latitude: '',
      longitude: '',
      name:'',
    }
  },

  // 修改地址
  changeAddress() {
    console.log('修改地址');
    wx.navigateTo({
      url: '../position/position',
    })
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    const obj = wx.getStorageSync('trueCity')
    if (obj.latitude) {
      console.log('adressObj:'+JSON.stringify(obj));
      this.setData({
        adressObj: obj
      })
      return false;
    }
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
const obj = wx.getStorageSync('trueCity');
    if (this.data.flag) {
      if (obj.longitude != this.data.adressObj.longitude || obj.latitude != this.data.adressObj.latitude) {
        console.log('地址变了');
        console.log('adressObj:'+JSON.stringify(obj));
        this.setData({
          adressObj: obj,
          index: 0
        });
        
      }
    }
    this.setData({
      flag: true
    })
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