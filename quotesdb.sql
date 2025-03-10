CREATE TABLE if NOT EXISTS authors (
    id SERIAL PRIMARY KEY,
    author varchar(50) NOT NULL
);

INSERT INTO authors (author)
VALUES
    ('Agatha Christie'),
    ('Arthur Conan Doyle'),
    ('Raymond Chandler'),
    ('Stephen King'),
    ('H.P. Lovecraft'),
    ('Shirley Jackson'),
    ('Isaac Asimov'),
    ('Ursula K. Le Guin'),
    ('Philip K. Dick'),
    ('Brandon Sanderson'),
    ('J.R.R. Tolkien'),
    ('George R.R. Martin'),
    ('C.S. Lewis'),
    ('Nora Roberts'),
    ('Nicholas Sparks'),
    ('Julia Quinn');

CREATE TABLE if NOT EXISTS categories (
    id SERIAL PRIMARY KEY,
    category varchar(50) NOT NULL
);

INSERT INTO categories (category)
VALUES
    ('Mystery'),
    ('Science Fiction'),
    ('Fantasy'),
    ('Horror'),
    ('Romance');


CREATE TABLE if NOT EXISTS quotes (
    id SERIAL PRIMARY KEY,
    quote TEXT NOT NULL,
    author_id INT NOT NULL,
    category_id INT NOT NULL,
    FOREIGN KEY (author_id) REFERENCES authors(id) ON DELETE RESTRICT,  -- Prevent deletion if referenced
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT  -- Prevent deletion if referenced
);

INSERT INTO quotes (quote, author_id, category_id)
VALUES
    ('"The best time to plant a tree was 20 years ago. The second best time is now." – Chinese Proverb', 1, 1),  -- Agatha Christie, Mystery
    ('"It’s not the size of the dog in the fight, it’s the size of the fight in the dog." – Mark Twain', 1, 1),  -- Agatha Christie, Mystery

    ('"When you have eliminated the impossible, whatever remains, however improbable, must be the truth." – Arthur Conan Doyle', 2, 1),  -- Arthur Conan Doyle, Mystery
    ('"Two things are infinite: the universe and human stupidity; and I’m not sure about the universe." – Albert Einstein', 2, 1),  -- Arthur Conan Doyle, Mystery

    ('"I was a nightmarish, sleuthing fool, but a fool nonetheless." – Raymond Chandler', 3, 1),  -- Raymond Chandler, Mystery
    ('"I have lived with several Zen masters — all of them cats." – Eckhart Tolle', 3, 1),  -- Raymond Chandler, Mystery

    ('"Monsters are real, and ghosts are real too. They live inside us, and sometimes, they win." – Stephen King', 4, 4),  -- Stephen King, Horror
    ('"There is no friend as loyal as a book." – Ernest Hemingway', 4, 4),  -- Stephen King, Horror

    ('"The most merciful thing in the world, I think, is the inability of the human mind to correlate all its contents." – H.P. Lovecraft', 5, 4),  -- H.P. Lovecraft, Horror
    ('"The world is full of magical things patiently waiting for our wits to grow sharper." – Bertrand Russell', 5, 4),  -- H.P. Lovecraft, Horror

    ('"I am a writer. Writing is a form of madness. It’s a fun kind of madness." – Shirley Jackson', 6, 4),  -- Shirley Jackson, Horror
    ('"I am not afraid of storms, for I am learning how to sail my ship." – Louisa May Alcott', 6, 4),  -- Shirley Jackson, Horror

    ('"Violence is the last refuge of the incompetent." – Isaac Asimov', 7, 2),  -- Isaac Asimov, Science Fiction
    ('"Do not go where the path may lead, go instead where there is no path and leave a trail." – Ralph Waldo Emerson', 7, 2),  -- Isaac Asimov, Science Fiction

    ('"The best way to predict the future is to invent it." – Ursula K. Le Guin', 8, 2),  -- Ursula K. Le Guin, Science Fiction
    ('"To boldly go where no man has gone before." – Gene Roddenberry', 8, 2),  -- Ursula K. Le Guin, Science Fiction

    ('"It is not the task of a writer to answer questions, but to ask them." – Philip K. Dick', 9, 2),  -- Philip K. Dick, Science Fiction
    ('"The only way to do great work is to love what you do." – Steve Jobs', 9, 2),  -- Philip K. Dick, Science Fiction

    ('"I write fantasy because it is the genre that speaks to me most directly about the human condition." – Brandon Sanderson', 10, 3),  -- Brandon Sanderson, Fantasy

    ('"Not all those who wander are lost." – J.R.R. Tolkien', 11, 3),  -- J.R.R. Tolkien, Fantasy
    ('"Winter is coming." – George R.R. Martin', 12, 3),  -- George R.R. Martin, Fantasy
    ('"You can make anything by writing." – C.S. Lewis', 13, 3),  -- C.S. Lewis, Fantasy

    ('"The key to happiness is the acceptance of life’s imperfections." – Nora Roberts', 14, 5),  -- Nora Roberts, Romance
    ('"Love is an endless act of forgiveness." – Nicholas Sparks', 15, 5),  -- Nicholas Sparks, Romance
    ('"True love is not about perfection, it’s about accepting each other’s flaws." – Julia Quinn', 16, 5);  -- Julia Quinn, Romance
