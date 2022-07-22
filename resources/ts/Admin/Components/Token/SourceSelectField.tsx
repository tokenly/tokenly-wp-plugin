import * as React from 'react'

import { 
	Flex,
	Spinner,
	SelectControl,
} from '@wordpress/components'
import SourceCollectionInterface from '../../../Interfaces/Collections/Token/SourceCollectionInterface'

interface SourceSelectFieldProps {
	source: any
	sources: SourceCollectionInterface
	loading: boolean
	onChange: any
	label?: string
	inputProps?: any
}

export default function SourceSelectField( props: SourceSelectFieldProps ) {
	function getSourceOptions() {
		const options = [
			{
				label: 'Not selected',
				value: '',
			}
		]
		if ( props.sources && typeof props.sources === 'object' ) {
			props.sources.forEach( ( value, key ) => {
				options.push( {
					label: value?.address.label ?? key,
					value: key,
				} )
			} )
		}
		return options
	}

	const sourceOptions = getSourceOptions()
	return (
			<Flex
				//@ts-ignore
				direction="column"
			>
				<Flex
					style={ { maxWidth: "320px" } }
					justify="flex-start"
					align="center"
					gap={ 4 }
				>
					<SelectControl
						label={ props?.label ?? 'Source' }
						disabled={ props.loading || sourceOptions.length === 1 }
						value={ props.source }
						style={ { width: '100%' } }
						options={ sourceOptions }
						onChange={ props.onChange }
						{ ...props.inputProps }
					/>
					{ props.loading &&
						<Spinner />
					}
				</Flex>
			</Flex>
	)
}
 

