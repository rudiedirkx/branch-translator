<?php

use rdx\branchtrans\Project;
use rdx\branchtrans\Source;

require 'inc.bootstrap.php';

$project = Project::find($_GET['project'] ?? PROJECT_ID);
$sources = Source::all('project_id = ? ORDER BY id', [$project->id]);

if (isset($_POST['project'], $_POST['opening'])) {
	$id = Project::insert([
		'name' => trim($_POST['project']),
	]);
	Source::insert([
		'project_id' => $id,
		'parent_source_id' => null,
		'source' => trim($_POST['opening']),
	]);

	return do_redirect(null, ['project' => $id]);
}

if (isset($_POST['parent'], $_POST['followup']) && isset($sources[ $_POST['parent'] ])) {
	Source::insert([
		'project_id' => $project->id,
		'parent_source_id' => $_POST['parent'],
		'source' => trim($_POST['followup']),
	]);

	return do_redirect(null, [
		'project' => $project->id,
		'start' => $_GET['start'] ?? null,
	]);
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
						<form method="post" action hidden>
							<input type="hidden" name="parent" value="<?= $source->id ?>" />
							<input name="followup" />
							<button>Save</button>
						</form>
					<? else: ?>
						<? if (!$branched): ?>
							<a href="?project=<?= $project->id ?>&start=<?= $source->id ?>"><?= html($source->source) ?></a>
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

<br>

<details>
	<summary>New project</summary>
	<form method="post" action>
		<p>Name: <input name="project" required /></p>
		<p>Opening text: <input name="opening" required /></p>
		<p><button>Create</button></p>
	</form>
</details>

<script>
function init() {
	const btns = $$('.followuppable button');
	btns.forEach(btn => btn.onclick = function(e) {
		const el = this.closest('tr').querySelector('form');
		el.hidden = !el.hidden;
		if (!el.hidden) {
			el.querySelector('input[name="followup"]').focus();
		}
	});
	btns[btns.length-1].focus();
}
</script>

<?php

include 'tpl.footer.php';
