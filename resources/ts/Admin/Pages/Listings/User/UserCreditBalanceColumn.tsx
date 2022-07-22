import * as React from 'react'
import { useState, useEffect } from 'react'
import { useInjection } from 'inversify-react'
import { TYPES } from '../../../Types'
import UserRepositoryInterface
	from '../../../../Interfaces/Repositories/UserRepositoryInterface'

import {
	Spinner,
} from '@wordpress/components'

import { 
	Fragment,
} from '@wordpress/element'
import AccountInterface
	from '../../../../Interfaces/Models/Credit/AccountInterface'

export interface UserCreditBalanceColumnProps {
	user: string
	group: string
}

export default function UserCreditBalanceColumn(
	props: UserCreditBalanceColumnProps
) {
	const userRepository: UserRepositoryInterface = useInjection(
		TYPES.Repositories.UserRepositoryInterface
	)

	const [ loading, setLoading ] = useState<boolean>( false )
	const [ balance, setBalance ] = useState<number>( null )

	useEffect( () => {
		setLoading( true )
		userRepository.creditBalanceShow(
			props.user, props.group
		).then( ( account?: AccountInterface ) => {
			if ( account ) {
				setBalance( account.balance )
			} else {
				setBalance( 0 )
			}
			setLoading( false )
		} ).catch( ( error: any ) => {
			setLoading( false )
		} )
	}, [] )

	return (
		<Fragment>
			{ ( !loading )
				?	<Fragment>{ balance }</Fragment>
				:	<Fragment><Spinner /></Fragment>
			}
		</Fragment>
	)
}
