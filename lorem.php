<?php
/*
* Utility functions for generating "lorem ipsum" Latin text.
*/

$common_p = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

$words = array('exercitationem', 'perferendis', 'perspiciatis', 'laborum', 'eveniet',
    'sunt', 'iure', 'nam', 'nobis', 'eum', 'cum', 'officiis', 'excepturi',
    'odio', 'consectetur', 'quasi', 'aut', 'quisquam', 'vel', 'eligendi',
    'itaque', 'non', 'odit', 'tempore', 'quaerat', 'dignissimos',
    'facilis', 'neque', 'nihil', 'expedita', 'vitae', 'vero', 'ipsum',
    'nisi', 'animi', 'cumque', 'pariatur', 'velit', 'modi', 'natus',
    'iusto', 'eaque', 'sequi', 'illo', 'sed', 'ex', 'et', 'voluptatibus',
    'tempora', 'veritatis', 'ratione', 'assumenda', 'incidunt', 'nostrum',
    'placeat', 'aliquid', 'fuga', 'provident', 'praesentium', 'rem',
    'necessitatibus', 'suscipit', 'adipisci', 'quidem', 'possimus',
    'voluptas', 'debitis', 'sint', 'accusantium', 'unde', 'sapiente',
    'voluptate', 'qui', 'aspernatur', 'laudantium', 'soluta', 'amet',
    'quo', 'aliquam', 'saepe', 'culpa', 'libero', 'ipsa', 'dicta',
    'reiciendis', 'nesciunt', 'doloribus', 'autem', 'impedit', 'minima',
    'maiores', 'repudiandae', 'ipsam', 'obcaecati', 'ullam', 'enim',
    'totam', 'delectus', 'ducimus', 'quis', 'voluptates', 'dolores',
    'molestiae', 'harum', 'dolorem', 'quia', 'voluptatem', 'molestias',
    'magni', 'distinctio', 'omnis', 'illum', 'dolorum', 'voluptatum', 'ea',
    'quas', 'quam', 'corporis', 'quae', 'blanditiis', 'atque', 'deserunt',
    'laboriosam', 'earum', 'consequuntur', 'hic', 'cupiditate',
    'quibusdam', 'accusamus', 'ut', 'rerum', 'error', 'minus', 'eius',
    'ab', 'ad', 'nemo', 'fugit', 'officia', 'at', 'in', 'id', 'quos',
    'reprehenderit', 'numquam', 'iste', 'fugiat', 'sit', 'inventore',
    'beatae', 'repellendus', 'magnam', 'recusandae', 'quod', 'explicabo',
    'doloremque', 'aperiam', 'consequatur', 'asperiores', 'commodi',
    'optio', 'dolor', 'labore', 'temporibus', 'repellat', 'veniam',
    'architecto', 'est', 'esse', 'mollitia', 'nulla', 'a', 'similique',
    'eos', 'alias', 'dolore', 'tenetur', 'deleniti', 'porro', 'facere',
    'maxime', 'corrupti');

$common_words = array('lorem', 'ipsum', 'dolor', 'sit', 'amet', 'consectetur',
    'adipisicing', 'elit', 'sed', 'do', 'eiusmod', 'tempor', 'incididunt',
    'ut', 'labore', 'et', 'dolore', 'magna', 'aliqua');

function sentence()
{
    /**
    * Returns a randomly generated sentence of lorem ipsum text.
    *
    * The first word is capitalized, and the sentence ends in either a period or
    * question mark. Commas are added at random.
    */

    # Determine the number of comma-separated sections and number of words in
   # each section for this sentence.
   global $words;

    for ($section_count = mt_rand(1, 5); $section_count; --$section_count)
    {
        foreach (array_rand($words, mt_rand(3, 12)) as $key)
            $section[] = $words[$key];
        $sentence[] = implode($section, ' ');
    }
    # Convert to sentence case and add end punctuation.
   return ucfirst(implode($sentence, ', ')) . (mt_rand(0, 1) ? '.' : '?');
}

function paragraph()
{
    /**
    * Returns a randomly generated paragraph of lorem ipsum text.
    * The paragraph consists of between 1 and 4 sentences, inclusive.
    */
    for ($sentence_count = mt_rand(1, 4); $sentence_count; --$sentence_count)
        $paragraph[] = sentence();

    return implode($paragraph, ' ');
}

function paragraphs($count, $isCommon = true)
{
    /**
    * Returns a list of paragraphs as returned by paragraph().
    *
    * If `common` is True, then the first paragraph will be the standard
    * 'lorem ipsum' paragraph. Otherwise, the first paragraph will be random
    * Latin text. Either way, subsequent paragraphs will be random Latin text.
    */
    global $common_p;

    for ($i = 0; $i < $count; $i++)
        if ($isCommon && $i == 0)
            $paras[] = $common_p;
        else
            $paras[] = paragraph();

    return implode($paras, "\n");
}

function words($count, $isCommon = true)
{
    /**
    * Returns a string of `count` lorem ipsum words separated by a single space.
    *
    * If `common` is True, then the first 19 words will be the standard
    * 'lorem ipsum' words. Otherwise, all words will be selected randomly.
    */
    global $common_words;
    global $words;

    if ($isCommon)
    {
        $common_word_count = count($common_words);

        if ($count > $common_word_count)
        {
            foreach (array_rand($words, $count - $common_word_count) as $key)
                $remaining_words[] = $words[$key];

            $word_list = array_merge($common_words, $remaining_words);
        }
        else
            $word_list = array_slice($common_words, 0, $count);
    }
    else
    {
        foreach (array_rand($words, $count) as $key)
            $word_list[] = $words[$key];
    }

    return implode($word_list, ' ');
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Lorem Ipsum</title>
</head>
<body>
  <h1>Lorem Ipsum Generator</h1>

  <h2>Sentence</h2>
  <p><?php echo sentence(); ?></p>
  <br>

  <h2>Paragraph</h2>
  <p><?php echo paragraph() ?></p>
  <br>

  <h2>3 Paragraphs</h2>
  <div>
    <p><?php echo paragraph() ?></p>
    <p><?php echo paragraph() ?></p>
    <p><?php echo paragraph() ?></p>
  </div>
  <br>

  <h2>5 Words</h2>
  <p><?php echo words(5) ?></p>
</body>
</html>