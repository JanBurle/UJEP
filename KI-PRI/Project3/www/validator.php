<? require __DIR__ . '/inc/start.php';
usrId() || redirect('login.php');

$title = 'XML validator';
require INC . '/html-prolog.php';
?>
<style>
  main {
    align-items: center;
  }

  textarea {
    width: 100%;
    white-space: nowrap;
    overflow: auto;
    font-family: monospace;
  }
</style>

<h1>XML Validator</h1>
<h2>Upload or paste files</h2>

<? require INC . '/validator.php' ?>

<form enctype="multipart/form-data" method="POST">
  <table>
    <tr>
      <td>XML file:</td>
      <td><input type="file" name="xml" accept=".xml" data-max-file-size="2M"></td>
    </tr>
    <tr>
      <td></td>
      <td>
        <textarea name="xml" rows="6"><?= $xmlText ?></textarea>
      </td>
    </tr>
    <tr>
      <td>DTD/XSD file:</td>
      <td><input type="file" name="dtd/xsd" accept=".dtd,.xsd" data-max-file-size="2M"></td>
    </tr>
    <tr>
      <td></td>
      <td>
        <textarea name="dtd/xsd" rows="6"><?= $valText ?></textarea>
      </td>
    </tr>
    <tr>
      <td></td>
      <td><input type="submit" value="Send"></td>
    </tr>
  </table>
</form>

<? require INC . '/html-epilog.php';
