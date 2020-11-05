<?php

use rdx\branchtrans\Source;

require 'inc.bootstrap.php';

$sources = Source::all('1=1 ORDER BY id');

if (isset($_POST['parent'], $_POST['followup']) && isset($sources[ $_POST['parent'] ])) {
	Source::insert([
		'parent_source_id' => $_POST['parent'],
		'source' => $_POST['followup'],
	]);

	return do_redirect(null, ['start' => $_GET['start'] ?? '']);
}

$path = Source::pathSources($sources, $_GET['start'] ?? null);
$colspan = count(end($path));
// print_r($path);

include 'tpl.header.php';

?>
<table border="1">
	<? $branched = false ?>
	<? foreach ($path as $options): ?>
		<tr>
			<? foreach ($options as $source): ?>
				<td colspan="<?= $colspan / count($options) ?>">
					<? if (count($options) == 1): ?>
						<div class="followuppable">
							<span><?= html($source->source) ?></span>
							<button>+follow up</button>
						</div>
						<form method="post" hidden>
							<input type="hidden" name="parent" value="<?= $source->id ?>" />
							<input name="followup" />
							<button>Save</button>
						</form>
					<? else: ?>
						<? if (!$branched): ?>
							<a href="?start=<?= $source->id ?>"><?= html($source->source) ?></a>
						<? else: ?>
							<? if (is_int($source)): ?>
								(<?= $source ?> options)
							<? elseif ($source): ?>
								<?= html($source->source) ?>
							<? endif ?>
						<? endif ?>
					<? endif ?>
				</td>
			<? endforeach ?>
		</tr>
		<? $branched |= count($options) > 1 ?>
	<? endforeach ?>
</table>

<script>
function init() {
	$$('.followuppable button').forEach(btn => btn.onclick = function(e) {
		const el = this.closest('tr').querySelector('form');
		el.hidden = !el.hidden;
	});
}
</script>

<?php

include 'tpl.footer.php';
