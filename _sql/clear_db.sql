use csemaildb;

delete from Tracking;
delete from EmailCurriculum;
delete from EmailAttachments;
delete from EmailClassStanding;
delete from Email;
ALTER TABLE Email AUTO_INCREMENT = 1;
delete from Students;
ALTER TABLE Students AUTO_INCREMENT = 1;
delete from ActiveProgram;
ALTER TABLE ActiveProgram AUTO_INCREMENT = 1;
delete from Curriculum;
ALTER TABLE Curriculum AUTO_INCREMENT = 1;

select * from Tracking;
select * from EmailCurriculum;
select * from EmailAttachments;
select * from EmailClassStanding;
select * from Email;
select * from Students;
select * from ActiveProgram;
select * from Curriculum;