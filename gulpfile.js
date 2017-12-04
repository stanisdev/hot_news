const chalk = require('chalk');
const gulp = require('gulp');
const { exec } = require('child_process');

gulp.task('restart', () => {
  exec('php Public/index.php', (error, stdout, stderr) => {
    if (error) {
      console.error(`Exec Error: ${error}`);
      return;
    }
    console.log(chalk.gray(`Response: `), chalk.yellow(stdout));
    console.log(chalk.gray(`Stderr: `), chalk.red(stderr));
  });
});

gulp.task('watch', () => {
  gulp.watch('/var/www/hot_news/*.php', ['restart']);
});

gulp.task('run', ['watch']);
