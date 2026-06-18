const Ziggy = {"url":"Https:\/\/localhost","port":null,"defaults":{},"routes":{"welcome":{"uri":"\/","methods":["GET","HEAD"]},"quiz":{"uri":"quiz","methods":["GET","HEAD"]},"quiz.question-bank":{"uri":"courses\/{course}\/question-bank","methods":["GET","HEAD"],"parameters":["course"],"bindings":{"course":"id"}},"courses.questions.store":{"uri":"courses\/{course}\/questions","methods":["POST"],"parameters":["course"],"bindings":{"course":"id"}},"app":{"uri":"app","methods":["GET","HEAD"]},"storage.local":{"uri":"storage\/{path}","methods":["GET","HEAD"],"wheres":{"path":".*"},"parameters":["path"]},"storage.local.upload":{"uri":"storage\/{path}","methods":["PUT"],"wheres":{"path":".*"},"parameters":["path"]}}};
if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
  Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };
