          <div class="history">
              <h3>История ставок (<span><?= htmlspecialchars(count($costs)); ?></span>)</h3>
              <?php foreach ($costs as $cost) : ?>
                  <table class="history__list">
                      <tr class="history__item">
                          <td class="history__name"><?= htmlspecialchars($cost['name']); ?></td>
                          <td class="history__price"><?= htmlspecialchars($cost['lot_price']); ?></td>
                          <td class="history__time"><?= htmlspecialchars($cost['date_posting']); ?> </td>
                      </tr>
                  </table>
              <?php endforeach; ?>
          </div>
