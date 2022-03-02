import { container } from './Inversify.config';
import '../../scss/Admin.scss';
import App from '../App';
import AdminAppInterface from './Interfaces/AdminAppInterface';
import AdminRouterInterface from './Interfaces/Routes/AdminRouterInterface';
import { TYPES } from './Types';

class AdminApp extends App implements AdminAppInterface {
	constructor() {
		super( container );
		const adminRouter = container.get<AdminRouterInterface>( TYPES.Routes.AdminRouterInterface );
	}
}

( function() {
	const admin = new AdminApp();
} )();
