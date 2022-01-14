import * as React from 'react';
import { useState } from 'react';
import { useInjection } from 'inversify-react';
import UserRepositoryInterface from '../../Interfaces/Repositories/UserRepositoryInterface';
import { TYPES } from '../../Types';

import { 
	// @ts-ignore
	ComboboxControl,
} from '@wordpress/components';

interface UserSearchFieldProps {
	onChange: any;
	user: any;
	label?: string;
	help?: string;
}

interface ComboboxOption {
	value: string,
	label: string,
}

export default function UserSearchField( props: UserSearchFieldProps ) {
	const userRepository: UserRepositoryInterface = useInjection( TYPES.Repositories.UserRepositoryInterface );

	const [ keywords, setKeywords ] = useState( '' );
	const [ options, setOptions ] = useState( [] );
	const [ searchTimeout, setSearchTimeout ] = useState( 0 );
	
	function getUserOptions( keywords: string ) {
		return new Promise( ( resolve, reject ) => {
			let newOptions = [] as any;
			if ( keywords == '' ) {
				resolve( newOptions );
			}
			searchDebounce( keywords ).then( ( optionsFound ) => {
				if ( optionsFound && Array.isArray( optionsFound ) ) {
					newOptions = optionsFound;
				}
				setOptions( newOptions );
				resolve( newOptions );
			} ).catch( ( error ) => {
				reject( error );
			} );
		});
	}

	function searchDebounce( keywords: string ) {
		clearTimeout( searchTimeout );
		return new Promise( ( resolve, reject ) => {
			setSearchTimeout( setTimeout(() => {
				const results = search( keywords );
				resolve( results );
			}, 500) );
		} );
	}

	function search( keywords: string ) {
		return new Promise( ( resolve, reject ) => {
			userRepository.index({
				suggestions: true,
				name: keywords,
			} ).then( ( results: Array<any> ) => {
				if ( results.length <= 0 ) {
					resolve( [] );
				} 
				const options = results.map( ( user: any ) => {
					return {
						value: user.id,
						label: user.name,
					} as ComboboxOption;
				} );
				if ( options.length > 1 ) {
					options.length = 1;
				}
				resolve( options );
			} ).catch( ( error: string ) => {
				reject( error );
			} );
		} );
	}

	function getKeywordsFromOptions() {
		let keywords = '';
		const optionsFiltered = options.filter( ( option: any ) => {
			return option.value == props.user;
		} );
		if ( optionsFiltered.length > 0 ) {
			keywords = optionsFiltered[0].label;
		}
		return keywords;
	}

	function onKeywordsChange( keywords: string ) {
		if ( keywords == '' && props.user ) {
			keywords = getKeywordsFromOptions();
		}
		getUserOptions( keywords ).then( ( options: any ) => {
			setOptions( options );
			setKeywords( keywords );
		} );
	}

	return (
		<div style={ { height: '40px' } }>
			<ComboboxControl
				label={ props.label }
				help={ props.help }
				value={ props.user }
				onChange={ props.onChange }
				options={ options }
				onFilterValueChange={ onKeywordsChange }
			/>
		</div>
	);
}
