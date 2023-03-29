<?php include_once 'views/templates/header.php'; ?>

    <div class="card" style="width: 97%; margin: 20px;">
        <div class="card-body">
            <h2 class="card-title text-center">TEST GRAMMARY CHECK</h2>
            <hr>
            <p>Here to select dictionary languaje. Default language English </p>
            
                    <select name="languageSelect" id="languageSelect">
                        <option value="englishupdated"> English </option>
                        <option value="frenchca"> French </option>
                        <option value="spanishca"> Spanish </option>
                    </select>
            <hr>
            <form method="post">
                <p>Spell check a word <input type="text" name="checkWord" id="checkWord" required>
                    <button class="btn btn-primary" type="button" id="btnGo">Go</button>
                </p>
            </form>
            <form method="post" enctype="multipart/form-data">
                Select File to Upload:
                <input class="btn btn-info" type="file" name="fileName" id="fileName">
                <input class="btn btn-primary" type="button" name="btnUpload" value="upload" id="btnUpload">
            </form>
            <br>
            <form method="post">
                <div>
                    File to check:
                    <input type="text" id="fileCheckName" name="fileCheckName">
                    <select name="fileExtension" id="fileExtension">
                        <option value="select">Select...</option>
                        <option value="txt"> .txt </option>
                        <option value="doc"> .doc </option>
                        <option value="docx"> .docx </option>
                        <option value="pdf"> .pdf </option>
                    </select>
                </div>
                <br>
                <p>Spell check uploaded essay <button class="btn btn-primary" type="button" id="btnCheck">Check</button>
                    <button class="btn btn-secondary" type="button" id="btnClear">Clear</button>
                </p>
            </form>
            <hr>
            <div class="col-lg-12 col-sm-12">
                <label>Text in file:</label>
                <div>
                    <textarea id="textInFile" class="form-control" name="textInFile" style="width: 100;"></textarea>
                </div>
            </div>
            <hr>
            <form class="p-4" id="editorForm" method="post" autocomplete="off">
                <div class="row">
                    <div class="col-lg-3 col-sm-3">
                        <label for="findWords">Words to find</label>
                        <div>
                            <textarea id="findWords" class="form-control" name="findWords" rows="10" cols="5"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-3">
                        <label for="textArea1">Mispelling Found</label>
                        <div class="form-group">
                            <textarea class="form-control" name="mispellingFound" id="mispellingFound" rows="10" cols="5" disabled></textarea>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <label for="textArea2">Occurrence found</label>
                        <div class="form-group">
                            <textarea class="form-control" name="occurrenceFound" id="occurrenceFound" rows="10" cols="5" disabled></textarea>
                        </div>
                    </div>
                </div>
            </form>
            <hr>
            <p style="text-align: center;">Words to find just one per line please.<br>
                Misspelling found are the words that are not in the dictionary.<br>
                Words found are the words to find in the document shows the amount.
            </p>
            <hr>
            <form method="post" autocomplete="off">
                <p>Add Word to Dictionary <input type="text" id="AddWordDictionary" name="AddWordDictionary" required>
                    <button class="btn btn-primary" type="button" id="btnAdd" name="btnAdd">Add</button>
                    <button class="btn btn-secondary" type="button" id="btnAddClear" name="btnAddClear">Clear</button>
                </p>
            </form>
            <hr>
            <form class="p-4" id="resultForm" autocomplete="off">
                <div class="row">
                    <div class="col-lg-4 col-sm-2">
                        <label>Error Amount</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-xmark"></i></span>
                            <input class="form-control" type="number" id="errorAmount" name="errorAmount" disabled>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-2">
                        <label>Error value</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-xmark"></i></span>
                            <input class="form-control" type="number" id="errorValue" name="errorValue">
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-2">
                        <label>Words Amount</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-xmark"></i></span>
                            <input class="form-control" type="number" id="wordsAmount" name="wordsAmount" disabled>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-2">
                        <label>Words value</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-xmark"></i></span>
                            <input class="form-control" type="number" id="wordsValue" name="wordsValue">
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-2">
                        <label>Essay Grade</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-marker"></i></span>
                            <input class="form-control" type="number" id="essayGrade" name="essayGrade">
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-2">
                        <label>Final Grade</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-award"></i></span>
                            <input class="form-control" type="number" id="finalGrade" name="finalGrade" disabled>
                        </div>
                    </div>
                </div>
            </form>
            <hr>
            <p style="text-align: center;">
                Error value is the amount of points to take off for each error.<br>
                Words value is the amount of points to add off for each word found.<br>
                On essay grade put the grade you want to give the essay.<br>
                Error and Words values don't use decimals like 0.25 instead use 25 to denote 25%,
                2 to denote 2% (0.02) and so on.
            </p>
            <hr>
            <div class="row">
                <div class="col-md-2">
                    <div class="input-group">
                        <div class="d-grid">
                            <button class="btn btn-primary" type="button" id="btnGrade">Grade Essay</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="input-group">
                        <div class="d-grid">
                            <button class="btn btn-info" type="button" id="btnSave">Save Essay</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="input-group">
                        <div class="d-grid">
                            <button class="btn btn-warning" type="button" id="btnNew">New Essay</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once 'views/templates/footer.php'; ?>