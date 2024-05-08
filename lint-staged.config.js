/** @type {import('lint-staged').Config} */
export default {
  '**/*.(ts|tsx|js)': () => [
    'yarn format',
    'yarn typecheck',
    'yarn format:write',
  ],
  '**/*.(md|json)': () => ['yarn format:write'],
};
