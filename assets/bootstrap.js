import { startStimulusApp } from '@symfony/stimulus-bundle';
// import { startStimulusApp } from '@symfony/stimulus-bridge';

// export const app = startStimulusApp(require.context(
//     '@symfony/stimulus-bridge/lazy-controller-loader!',
//     true,
//     /\.[jt]sx?$/
// ));
const app = startStimulusApp();
// enregistrez ici tout contrôleur personnalisé ou tiers
// app.register('some_controller_name', SomeImportedController);
