CREATE TABLE `users` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY,
  `nick` varchar(32) NOT NULL,
  `color` varchar(16) NOT NULL,
  `password` varchar(32) NOT NULL,
  `sign` varchar(3) NOT NULL,
  `level` int(11) NOT NULL,
  `per_page` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Hasło dla konta Admin to adminpass, a dla Guest to guest
INSERT INTO `users` (`id`, `nick`, `color`, `password`, `sign`, `level`, `per_page`) VALUES
(1, 'Admin', '#b30000', '25e4ee4e9229397b6b17776bfceaf8e7', '@', 10, 15), 
(2, 'Guest', '#111', '084e0343a0486ff05530df6c705c8bb4', '~', 1, 15);

CREATE TABLE `messages` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY,
  `type` int(11) NOT NULL,
  `nick` varchar(32) NOT NULL,
  `time` int(11) NOT NULL DEFAULT current_timestamp(),
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `messages` (`type`, `nick`, `time`, `message`) VALUES
(1, 'Admin', 1604854294, 'Wiadomość testowa'),
(2, 'Admin', 1604854313, 'A to jest ogłoszenie');

CREATE TABLE `topic` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY,
  `topic` varchar(256) NOT NULL,
  `who` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `topic` (`topic`, `who`) VALUES
('Temat testowy', 'Admin');

