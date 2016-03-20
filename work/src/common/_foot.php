      <div class="row text-center">
        <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-1806842962334528" data-ad-slot="6754681097" data-ad-format="auto"></ins>
        <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
      </div>
    </div>
    <div id="col-right" class="col-md-3 col-right">
      <div class="row text-center">
        <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-1806842962334528" data-ad-slot="9847748293" data-ad-format="auto"></ins>
        <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
      </div>
      <div class="panel-heading">
        <h3 class="panel-title text-center">ブログ一覧</h3>
      </div>
      <div class="panel-body">
        <label for="blog-search">絞り込みform</label>
        <select id="blog-search" class="form-control">
          <option v-for="list in blogLists" value="{{ list.path }}">{{ list.genre }}</option>
        </select>
      </div>

      <table id="blog-histry" class="table table-striped">
        <tr v-for="list in blogLists">
          <td><a href="{{ list.href }}"><strong>{{ list.title }}</strong></a></td>
          <td><a href="{{ list.href }}"><small>{{ list.blogtype }}</small></a></td>
          <td><a href="{{ list.href }}"><small>{{ list.date }}</small></a></td>
        </tr>
      </table>
    </div>
  </div>
</div>
<script src="/js/makelist.js"></script>
</body>
</html>
