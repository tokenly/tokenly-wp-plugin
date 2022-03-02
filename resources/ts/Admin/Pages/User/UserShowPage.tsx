import * as React from 'react';
import { useState, useEffect } from 'react';
import { useInjection } from 'inversify-react';
import UserRepositoryInterface from '../../../Interfaces/Repositories/UserRepositoryInterface';
import { TYPES } from '../../Types';
import Connection from '../../Components/Connection';
import FormTable from '../../Components/FormTable';
import Preloader from '../../Components/Preloader';

interface UserShowPageProps {
	can_connect: boolean;
}

export default function UserShowPage( props: UserShowPageProps ) {
	const userRepository: UserRepositoryInterface = useInjection( TYPES.Repositories.UserRepositoryInterface );

	const [ user, setUser ] = useState<any>( null );
	const [ loadingUser, setLoadingUser ] = useState<boolean>( false );

	useEffect( () => {
		setLoadingUser( true );
		userRepository.show( 'me', {
			with: [ 'oauth_user' ],
		} ).then( ( userFound: any ) => {
			setLoadingUser( false );
			setUser( userFound );
		} );
	}, [] );

	return (
		<div id="tokenly">
			<h2>Tokenly</h2>
			{ loadingUser
			?	<Preloader loading={ loadingUser } />
			:	<FormTable rows={
					[
						{
							label: 'Connection',
							component: <Connection user={ user } />
						},
					]
				} />
			}
		</div>
	);
}
 

