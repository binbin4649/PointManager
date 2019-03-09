<tr>
  <th>PointManager</th>
  <td>
    <ul class="cleafix">
      <li>
        <?php $this->bcBaser->link('PM一覧', array('controller' => 'pmpages', 'action' => 'index')) ?>
      </li>
      <li>
        <?php $this->bcBaser->link('請求一覧', array('controller' => 'pmtotals', 'action' => 'index')) ?>
      </li>
      <li>
        <?php $this->bcBaser->link('PM新規追加', array('controller' => 'pmpages', 'action' => 'add')) ?>
      </li>
      <li>
        <?php $this->bcBaser->link('PM既存紐付', array('controller' => 'pmpages', 'action' => 'ass')) ?>
      </li>
      <li>
        <?php $this->bcBaser->link('Config', array('controller' => 'pmconfigs', 'action' => 'edit')) ?>
      </li>
    </ul>
  </td>
</tr>