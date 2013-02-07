
// parse journal article 

function isNumeric(num) {
  var numbers = ['0','1','2','3','4','5','6','7','8','9'];
  for (var i = 0; i < numbers.length; i++) {
    if (num == numbers[i]) {
      return true;
    }
  }
  return false;
}

function firstNumericIndex(str) {
  console.log(str);
  for (var i = 0; i < str.length; i++) {
    if (isNumeric(str.charAt(i))) {
      console.log(i);
      return i;
    }
  }
  return -1;
}

function firstNumericSubsequence(str) {
  var start = firstNumericIndex(str);
  var sequence = [];
  for (var i = start; i < str.length; i++) {
    if (isNumeric(str.charAt(i))) {
      sequence.push(str.charAt(i));
    } else {
      break;
    }
  }
  console.log(sequence);
  return sequence.join('');
}

function parse_article(text) {

  // optimism 
  var failed = false; 

  // get index of first double quote 
  var title_start = 0;
  var title_end = 0;
  if (text.indexOf('“') > -1) { 
    title_start = text.indexOf('“');
    title_end = text.indexOf('”');
  } else if (text.indexOf('"') > -1) {
    title_start = text.indexOf('"');
    title_end = text.lastIndexOf('"');
  }

  if (title_end <= title_start || title_start == 0) {
    console.log('failed to find title');
  }

  var title = text.substr(title_start + 1, (title_end - title_start) - 1);
  if (title.charAt(title.length - 1) == '.') {
    title = title.substr(0, title.length - 1);   
  }

  var tokens = text.substr(0, title_start).split(',');
  if (tokens.length % 2 != 0) {
    console.log('failed to get even number of author tokens');
  }

  var authors = [];
  for (var i = 0; i < tokens.length / 2; i++) {
    authors[i] = tokens[i*2].trim() + ', ' + tokens[i*2+1].trim();
  }

  var journal_info = text.substr(title_end + 1, text.length - title_end - 1);
  journal_info = journal_info.replace('–', '-');

  var volume = firstNumericSubsequence(journal_info);
  var journal_title = journal_info.substr(0, journal_info.indexOf(volume)).trim();

  var pages = '';
  var journal_tokens = journal_info.split(' ');
  for (var i = 0; i < journal_tokens.length; i++) {
    if (journal_tokens[i].indexOf('-') != -1) {
      if (journal_tokens[i].length > 1) {
        pages = journal_tokens[i];
      } else {
        if (i > 0 && i < journal_tokens.length - 1) {
          var first_token = journal_tokens[i-1];
          var second_token = journal_tokens[i+1];
          pages = first_token.trim() + '-' + second_token.trim();
        } else {
          console.log('could not find page numbers');
        }
      }
    }
  }

  var year_start = journal_info.lastIndexOf('(');
  var year_end = journal_info.lastIndexOf(')');

  if (year_end < 0 || year_start < 0 || year_end <= year_start) {
    console.log('failed to find year');
  }

  var year = journal_info.substr(year_start + 1, 4);

  var authors_imploded = authors.join('\n');

  $('.textarea-authors').val(authors_imploded);
  $('.input-title').val(title);
  $('.input-year').val(year);
  $('.input-journal').val(journal_title);
  $('.input-pages').val(pages);
  $('.input-volume').val(volume);

  return { 'authors' : authors, 'title' : title, 
    'journal' : journal_title, 'year' : year, 'pages' : pages, 
    'volume' : volume };

}