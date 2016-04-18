/**
 * blogのリストを取得して表示する
 */
$(function(){
var makeBlogList = function() {
  this.init.call(this);
}

/**
 * 初期化処理
 */
makeBlogList.prototype.init = function() {
  this.blogList = [];

  // 検索ボックスの方
  this.searchBoxVue = new Vue({
    el: '#blog-search',
    data: {
      blogLists: []
    },
    watch: {
      blogLists: this.searchList.bind(this)
    }
  });

  // ブログリストの方
  this.blogListVue = new Vue({
    el: '#blog-histry',
    data: {
      blogLists: []
    }
  });

  $('#blog-search').on('change', this.searchList.bind(this));
  this.getList();
}

/**
 * リストの取得
 * index.jsonからブログリストを取ってくる
 */
makeBlogList.prototype.getList = function() {
$.ajax({
  type: "GET",
  url: "/blog/index.json",
  dataType: "json",
  success: (function(data) {
    this.blogList = data;
    this.setSerchBox();
  }).bind(this)
});
}

/**
 * 検索用のselectboxの動的書き出し
 */
makeBlogList.prototype.setSerchBox = function() {
  var list = {
    '/blog': {
      name: '全部',
      genre: '/blog'
    }
  };

  $.each(this.blogList, function(i, val){
    var tmp = val['blogtype'].split('/');

    list[val['blogtype']] = {
      name: tmp[tmp.length - 1],
      genre: val['blogtype']};
  });

  this.searchBoxVue.$data.blogLists = objectSort(list);

  /**
   * objectをkeyでsortする
   * @param Object obj
   * @return Array
   */
  function objectSort(obj) {
    var sorted = {};
    var arr = [];

    // keyを取得する
    for (key in obj) {
      if (obj.hasOwnProperty(key)) {
        arr.push(key);
      }
    }

    // keyをソート
    arr.sort(); 

    // 返却用objectに値を入れなおす
    for (var i = 0, l = arr.length; i < l; i++) {
      sorted[arr[i]] = obj[arr[i]];
    }

    return sorted;
  }

}

/**
 * リストに書き出すブログの絞り込み
 * 検索条件を増やす時はこの辺りをいじる
 */
makeBlogList.prototype.searchList = function() {
  var type = $('#blog-search').val();
  var list = [];
  $.each(this.blogList, function(i, val){
    if(val['blogtype'].indexOf(type) !== -1) {
      list.push(val);
    }
  });

  this.blogListVue.$data.blogLists = list;
}

new makeBlogList();
});