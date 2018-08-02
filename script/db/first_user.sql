INSERT INTO agora.roles (`role`, `enabled`) VALUES('Administrator', 1);
INSERT INTO agora.roles (`role`, `enabled`) VALUES('Staff Super User', 1);
INSERT INTO agora.roles (`role`, `enabled`) VALUES('Staff User', 1);
INSERT INTO agora.roles (`role`, `enabled`) VALUES('User', 1);
INSERT INTO agora.roles (`role`, `enabled`) VALUES('Guest', 1);

INSERT INTO agora.contact (`role_id`, `username`, `usersurname`, `password`, `locked`, `email`, `subscriber`)
VALUES((SELECT id FROM agora.roles WHERE role = 'Administrator'), 'Administrator', 'Administrator',
'xxx', '0', 'admin@agora.com', '1');

INSERT INTO agora.role_routes (`role_id`, `route`) 
VALUES((SELECT role_id FROM agora.contact WHERE email = 'benshez@gmail.com'), 'roles.get');
